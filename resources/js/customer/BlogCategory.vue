<template>
    <div>
        <main class="container">
            <div class="starter-template text-left py-5 px-2 mt-3">
                <h1>Blog Category</h1>
            </div>

            <div class="row">
                <div class="col mb-3">
                    <router-link to="/customer/blog-category/add" class="btn btn-lg btn-warning"
                        >Add new Category</router-link
                    >
                </div>
            </div>

            <div class="alert alert-warning" v-if="loaded">
                <span class="spinner-border text-warning mr-3"></span>Please wait... loading category records...
            </div>

            <table class="table table-stripped" v-if="!loaded">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="category_data in category" v-if="category.length > 0">
                        <td>{{ category_data.name }}</td>
                        <td>
                            <router-link :to="`/customer/blog-category/edit/${category_data.id}`">Edit</router-link>
                            |
                            <router-link
                                :to="{ name: 'blog-category' }"
                                v-on:click.native="deleteRecord(`${category_data.id}`)"
                                >Delete</router-link
                            >
                        </td>
                    </tr>
                    <tr v-if="category.length === 0">
                        <td colspan="2" class="text-danger">No Record Found</td>
                    </tr>
                </tbody>
            </table>
        </main>
    </div>
</template>

<script>
export default {
    data() {
        return {
            category: [],
            loaded: true,
        };
    },
    created() {
        this.$query("category").then((res) => {
            console.log(res);
            this.loaded = false;
            this.category = res.data.data.category;
        });
    },
    methods: {
        deleteRecord(category_id) {
            this.$swal({
                title: "Are you sure?",
                text: "You want to delete this record?",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it",
            }).then((result) => {
                if (result.value) {
                    //delete record
                    this.$query("category", {
                        delete_category_id: category_id,
                    }).then((res) => {
                        this.loaded = false;
                        this.category = res.data.data.category;
                    });
                }
            });
        },
    },
};
</script>
