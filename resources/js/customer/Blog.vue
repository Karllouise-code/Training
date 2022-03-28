<template>
    <div>
        <main class="container">
            <div class="starter-template text-left py-5 px-2 mt-3">
                <h1>Blogs</h1>
            </div>

            <div class="row">
                <div class="col mb-3">
                    <router-link to="/customer/blogs/add" class="btn btn-lg btn-warning">Add new Blog</router-link>
                </div>
            </div>

            <div class="alert alert-warning" v-if="loaded">
                <span class="spinner-border text-warning mr-3"></span>Please wait... loading blog records...
            </div>

            <table class="table table-stripped" v-if="!loaded">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="blog_data in blogs" v-if="blog.length > 0">
                        <td>{{ blog_data.title }}</td>
                        <td>category name</td>
                        <td>
                            <router-link :to="`/customer/blogs/edit/${blog_data.id}`">Edit</router-link>
                            |
                            <router-link :to="{ name: 'blogs' }" v-on:click.native="deleteRecord(`${blog_data.id}`)"
                                >Delete</router-link
                            >
                        </td>
                    </tr>
                    <tr v-if="blogs.length === 0">
                        <td colspan="3" class="text-danger">No Record Found</td>
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
            blogs: [],
            loaded: true,
        };
    },
    created() {
        this.$query("blogs").then((res) => {
            console.log(res);
            this.loaded = false;
            this.blogs = res.data.data.blogs;
        });
    },
    methods: {
        deleteRecord(blog_id) {
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
                    this.$query("blogs", {
                        delete_blog_id: blog_id,
                    }).then((res) => {
                        this.loaded = false;
                        this.blogs = res.data.data.blogs;
                    });
                }
            });
        },
    },
};
</script>
