<template>
    <div>
        <main class="container">
            <div class="starter-template text-left py-5 px-2 mt-3">
                <h1>Update Blogs</h1>
            </div>

            <div class="alert alert-warning" v-if="isSaving">
                <span class="spinner-border text-warning mr-3"></span>Please wait... saving blogs records...
            </div>
            <form @submit.prevent="submitForm">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Category</label>
                            <select v-model="selected_category" class="form-control">
                                <option value="">Select one</option>
                                <option :value="category_data.id" v-for="category_data in category">
                                    {{ category_data.name }}
                                </option>
                            </select>
                            <div class="text-danger">{{ category_error }}</div>
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input v-model="title" type="text" class="form-control" placeholder="Name" />
                            <div class="text-danger">{{ title_error }}</div>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea v-model="description" type="text" class="form-control"></textarea>
                            <div class="text-danger">{{ description_error }}</div>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-sm btn-primary" type="submit">Save</button>
                            <router-link to="/customer/blogs" class="btn btn-sm btn-default">Back</router-link>
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
            title: "",
            selected_category: "",
            description: "",
            title_error: "",
            category_error: "",
            description_error: "",
            isSaving: false,
            category: [],
        };
    },

    created() {
        this.$query("category").then((res) => {
            this.loaded = false;
            this.category = res.data.data.category;
        });

        this.$query("blogs", {
            blog_id: this.$route.params.id,
        }).then((res) => {
            console.log(res);
            let blog_data = res.data.data.blogs[0];
            this.title = blog_data.title;
            this.description = blog_data.description;
        });
    },
    methods: {
        submitForm() {
            this.isSaving = true;
            this.$query("saveblogs", {
                blog: {
                    title: this.title,
                    category_id: this.selected_category,
                    description: this.description,
                    id: this.$route.params.id,
                },
            }).then((res) => {
                console.log(res);
                this.isSaving = false;
                if (res.data.errors) {
                    let errors = Object.values(res.data.errors[0].extensions.validation).flat();
                    let errors_keys = Object.keys(res.data.errors[0].extensions.validation).flat();

                    this.title_error = errors_keys.some((q) => q === "blog.title")
                        ? errors[errors_keys.indexOf("blog.title")]
                        : "";
                    this.description_error = errors_keys.some((q) => q === "blog.description")
                        ? errors[errors_keys.indexOf("blog.description")]
                        : "";
                    this.category_error = errors_keys.some((q) => q === "blog.category")
                        ? errors[errors_keys.indexOf("blog.category")]
                        : "";
                } else {
                    let response = res.data.data.saveblogs;
                    if (response.error == false) {
                        //display success message
                        this.$swal("Success!", response.message, "success");
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
