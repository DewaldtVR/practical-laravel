<?php
/**
 * Created by PhpStorm.
 * User: werner
 * Date: 2019/02/03
 * Time: 19:00
 */

namespace App\Classes\Storage;


use App\Models\File;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileHandler
{
    protected $disk;
    protected $hooks = [];
    protected $directory;
    protected $request;
    protected $key;
    protected $private = 0;
    protected $config = [
        "bucket" => "AWS_BUCKET",
        "bucket.private" => "AWS_BUCKET_PRIVATE",
        "driver" => "s3",
        "model" => File::class
    ];

    public static function request(Request $request, $key = "file")//Uploader entry point
    {
        $class = new self;
        $class->request = $request;
        $class->key = $key;
        return $class;
    }

    /**
     * @throws  \Exception
     */
    public function setPrivateBucket($bucket)
    {
        if (in_array("bucket.private", $this->config) && $bucket) {
            $this->config["bucket.private"] = $bucket;
        } else {
            throw new \Exception("The private bucket is not specified in the config array.");
        }
    }

    /**
     * @throws  \Exception
     */
    public function setBucket($bucket)
    {
        if (in_array("bucket", $this->config) && $bucket) {
            $this->config["bucket"] = $bucket;
        } else {
            throw new \Exception("The bucket is not specified in the config array.");
        }
    }

    public function disk($disk = "s3")
    {
        $this->disk = $disk;
        return $this;
    }

    public function directory($directory)
    {
        $this->directory = $directory;
        return $this;
    }

    public function private($isPrivate = true)
    {
        $this->private = $isPrivate ? 1 : 0;
        return $this;
    }

    public function public()
    {
        $this->private = 0;
        return $this;
    }

    public function afterUpload($function)
    {
        $this->hooks['afterUpload'] = $function;
        return $this;
    }

    public function beforeDownload($function)
    {
        $this->hooks['beforeDownload'] = $function;
        return $this;
    }

    public function beforeDelete($function)
    {
        $this->hooks['beforeDelete'] = $function;
        return $this;
    }

    public function afterDelete($function)
    {
        $this->hooks['afterDelete'] = $function;
        return $this;
    }

    /**
     * @throws  \Exception
     */
    public function getBucket()
    {
        if ($this->disk) {
            if ($this->private == 1)
                return $this->getPrivateBucketName();
            else return $this->getBucketName();
        } else {
            throw  new \Exception("The disk is not specified");
        }
    }

    /**
     * @throws  \Exception
     */
    public function getPrivateBucketName()
    {
        if ($this->config["bucket.private"] && env($this->config["bucket.private"]))
            return $this->config["bucket.private"];
        else throw new \Exception("The private bucket is not specified in the ..env file, make sure it exists.");
    }

    /**
     * @throws  \Exception
     */
    public function getBucketName()
    {
        if ($this->config["bucket"] && env($this->config["bucket"]))
            return $this->config["bucket"];
        else throw new \Exception("The bucket is not specified in the ..env file, make sure it exists.");
    }


    private function initStorage()
    {
        if (!$this->disk)
            $this->disk = $this->config["driver"];
    }

    private function executeAfterUpload(&$model)
    {
        if (array_key_exists('afterUpload', $this->hooks) && is_callable($this->hooks['afterUpload'])) {
            $func = $this->hooks['afterUpload'];
            $func($model);
        }
        return $model;
    }

    private function executeBeforeDelete(&$model)
    {
        if (array_key_exists('beforeDelete', $this->hooks) && is_callable($this->hooks['beforeDelete'])) {
            $func = $this->hooks['beforeDelete'];
            $func($model);
        }
        return $model;
    }

    private function executeAfterDelete()
    {
        if (array_key_exists('afterDelete', $this->hooks) && is_callable($this->hooks['afterDelete'])) {
            $func = $this->hooks['afterDelete'];
            $func();
        }
        return;
    }

    private function executeBeforeDownload(&$model)
    {
        if (array_key_exists('beforeDownload', $this->hooks) && is_callable($this->hooks['beforeDownload'])) {
            $func = $this->hooks['beforeDownload'];
            $func($model);
        }
        return $model;
    }

    /**
     * @throws  \Exception
     */
    private function getRequestFile()
    {
        if ($this->request->hasFile($this->key))
            return $this->request->file($this->key);
        else
            throw  new \Exception("No file found with key: " . $this->key);
    }

    /**
     * @throws  \Exception
     */
    private function putFile(UploadedFile $file)
    {
        $this->initStorage();
        $filePath = $this->directory . "/" . time() . $file->getClientOriginalName();
        try {

            Storage::disk($this->disk)->put($filePath, file_get_contents($file), [
                'ContentType' => $file->getClientMimeType()
            ]);

            if (!$this->private)
                Storage::disk($this->disk)
                    ->setVisibility($filePath, "public");

            $fileData = [
                "filename" => $filePath,
                "originalfilename" => $file->getClientOriginalName(),
                "mimetype" => $file->getClientMimeType(),
                "size" => $file->getSize(),
                "private" => $this->private,
                "url" => Storage::disk($this->disk)->url($filePath)
            ];
            return response($this->createModelInstance($fileData), 200);
        } catch (\Exception $e) {
            throw  new \Exception($e->getMessage());
        }
    }

    /**
     * @throws  \Exception
     */
    private function createModelInstance($fileData)
    {
        if ($this->config["model"]) {
            $file = new $this->config["model"];
            $file->filename = $fileData["filename"];
            $file->originalfilename = $fileData["originalfilename"];
            $file->mimetype = $fileData["mimetype"];
            $file->private = $fileData["private"];
            $file->size = $fileData["size"];
            $file->url = asset($fileData["url"]);

            if (in_array($fileData["mimetype"], ["image/jpeg", "image/png", "image/svg", "image/gif"])) {
                $file->thumbnail = asset($fileData["url"]);
            }

            $file->save();
            $this->executeAfterUpload($file);
            return $file;
        } else {
            throw  new \Exception("Model not defined for uploader.");
        }
    }

    /**
     * @throws  \Exception
     */
    private function handleDownload($fileid)
    {
        $file = $this->config["model"]::find($fileid);
        if ($file) {
            $originalName = $file->originalfilename;
            $this->executeBeforeDownload($file);
            if ($file->private == 1) {
                $this->initStorage();
                $file->url = Storage::disk($this->disk)->temporaryUrl(
                    $file->filename,
                    Carbon::now()->addMinutes(5),
                    [
                        'ResponseContentType' => $file->mimetype,
                        'ResponseContentDisposition' => 'attachment; filename=' .$file->originalfilename,
                    ]
                );

                $file->originalfilename = $originalName;
                $file->save();
            }
            return response(["url" => $file->url], 200);
        } else {
            throw new \Exception("File not found");
        }
    }


    /**
     * @throws  \Exception
     */
    private function handleDelete($fileid)
    {

        $file = $this->config["model"]::find($fileid);
        if ($file) {
            if ($file->private == 1) {
                $this->private = 1;
                $this->initStorage();
                if (Storage::disk($this->disk)->exists($file->filename)) {
                    try {
                        Storage::disk($this->disk)->delete($file->filename);
                        $this->executeBeforeDelete($file);
                        $file->delete();
                        $this->executeAfterDelete();
                        return response("File deleted.", 200);
                    } catch (\Exception $e) {
                        throw new \Exception($e->getMessage());
                    }
                }
            } else {
                $this->private = 0; //1230 x 2450  //10mm,1,1x0,5 //5mm, 1,18x 0,6
                $this->initStorage();
                if (Storage::disk($this->disk)->exists($file->filename)) {
                    try {
                        Storage::disk($this->disk)->delete($file->filename);
                        $this->executeBeforeDelete($file);
                        $file->delete();
                        $this->executeAfterDelete();
                        return response("File deleted.", 200);
                    } catch (\Exception $e) {
                        throw new \Exception($e->getMessage());
                    }
                }
            }

            return response("Deleted", 200);
        } else {
            throw new \Exception("File not found");
        }
    }

    public function process()
    {
        if ($this->request) {
            if ($this->request->command == "upload")
                return $this->putFile($this->getRequestFile());
            else if ($this->request->command == "download")
                return $this->handleDownload($this->request->get("fileid"));
            else if ($this->request->command == "delete")
                return $this->handleDelete($this->request->get("fileid"));
        } else {
            return response("Request not present", 500);
        }
    }
}