
export default {
    computed: {
        stateColors() {
            return {
                "warning": this.$vuetify.theme.warning,
                "success": this.$vuetify.theme.success,
                "primary": this.$vuetify.theme.primary,
                "error": this.$vuetify.theme.error,
                "accent": this.$vuetify.theme.accent,
                "disabled": this.$vuetify.theme.disabled,
                "terminated" : this.$vuetify.theme.warning
            };
        },
        serviceTypes() {
            return [
                {
                    text: "Express",
                    value: "express"
                },
                {
                    text: "High Assurance",
                    value: "high_assurance"
                }
            ]
        },
        stateProps() {
            return {
                created: {
                    text: "Created",
                    icon: "home",
                    color: this.stateColors["primary"]
                },
                pending: {
                    text: "Validating",
                    icon: "schedule",
                    color: this.stateColors["warning"]
                },
                incomplete: {
                    text: "Missing Info",
                    icon: "error",
                    color: this.stateColors["error"]
                },
                processing: {
                    text: "Processing",
                    icon: "autorenew",
                    color: this.stateColors["accent"]
                },
                completed: {
                    text: "Completed",
                    icon: "check_circle",
                    color: this.stateColors["success"]
                },
                archived: {
                    text: "Archived",
                    icon: "delete",
                    color: this.stateColors["disabled"]
                },
                terminated: {
                    text: "Terminated",
                    icon: "delete",
                    color: this.stateColors["disabled"]
                }
            }
        },
    },
    methods: {
        getStateColor: function (state) {
            return this.stateProps[state].color;
        },
        getStateText: function (state) {
            return this.stateProps[state].text;
        },
        getStateIcon: function (state) {
            return this.stateProps[state].icon;
        },
        getServiceTypeText: function (type) {
            return this.serviceTypes[type].text;
        }
    }
}