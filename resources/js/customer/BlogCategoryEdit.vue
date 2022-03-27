<template>
    <div>
        <main class="container">
            <div class="starter-template text-left py-5 px-2 mt-3">
                <h1>Update Blog Category</h1>
            </div>

            <div class="alert alert-warning" v-if="isSaving">
                <span class="spinner-border text-warning mr-3"></span>Please wait... saving category records...
            </div>
            <div class="alert alert-warning" v-if="loaded">
                <span class="spinner-border text-warning mr-3"></span>Please wait... loading category records...
            </div>

            <form @submit.prevent="submitForm">
                <div class="row" v-if="!loaded">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name</label>
                            <input v-model="name" type="text" class="form-control" placeholder="Name" />
                            <div class="text-danger">{{ name_error }}</div>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-sm btn-primary" type="submit">Save</button>
                            <router-link to="/customer/blog-category" class="btn btn-sm btn-default">Back</router-link>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: "",
            name_error: "",
            isSaving: false,
            loaded: true,
        };
    },
    created() {
        this.$query("category", {
            category_id: this.$route.params.id,
        }).then((res) => {
            this.loaded = false;
            let category = res.data.data.category[0];
            this.name = category.name;
        });
    },

    methods: {
        submitForm() {
            this.isSaving = true;
            this.$query("savecategory", {
                name: this.name,
                id: this.$route.params.id,
            }).then((res) => {
                this.isSaving = false;
                if (res.data.errors) {
                    let errors = Object.values(res.data.errors[0].extensions.validation).flat();
                    let errors_keys = Object.keys(res.data.errors[0].extensions.validation).flat();
                    this.name_error = errors_keys.some((q) => q === "name") ? errors[errors_keys.indexOf("name")] : "";
                } else {
                    let response = res.data.data.savecategory;
                    if (response.error == false) {
                        //display success message
                        this.$swal("Success!", response.message, "success");
                        this.name_error = "";
                    } else {
                        //display error message
                        this.$swal("Error!", response.message, "error");
                    }
                }
            });
        },
    },
};
</script>
