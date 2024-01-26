<?php

namespace App\Observers;

use App\Models\RelatedParty;

class RelatedPartyObserver
{
    /**
     * Handle the RelatedParty "created" event.
     *
     * @param  \App\Models\RelatedParty  $relatedParty
     * @return void
     */
    public function created(RelatedParty $relatedParty)
    {
        event(new RelatedPartyCreated($relatedParty));
    }

    /**
     * Handle the RelatedParty "updated" event.
     *
     * @param  \App\Models\RelatedParty  $relatedParty
     * @return void
     */
    public function updated(RelatedParty $relatedParty)
    {
        //
    }

    /**
     * Handle the RelatedParty "deleted" event.
     *
     * @param  \App\Models\RelatedParty  $relatedParty
     * @return void
     */
    public function deleted(RelatedParty $relatedParty)
    {
        //
    }

    /**
     * Handle the RelatedParty "restored" event.
     *
     * @param  \App\Models\RelatedParty  $relatedParty
     * @return void
     */
    public function restored(RelatedParty $relatedParty)
    {
        //
    }

    /**
     * Handle the RelatedParty "force deleted" event.
     *
     * @param  \App\Models\RelatedParty  $relatedParty
     * @return void
     */
    public function forceDeleted(RelatedParty $relatedParty)
    {
        //
    }
}
