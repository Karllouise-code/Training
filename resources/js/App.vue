<template>
    <div>
        <div v-if="loggedIn">
            <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
                <a class="navbar-brand" href="#">One Blog</a>
                <button
                    class="navbar-toggler"
                    type="button"
                    data-toggle="collapse"
                    data-target="#navbarsExampleDefault"
                    aria-controls="navbarsExampleDefault"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <router-link to="/customer/dashboard" class="nav-link">Dashboard</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/customer/blog-category" class="nav-link">Blog Category</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/customer/blogs" class="nav-link">Blogs</router-link>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Profile</a>
                        </li>
                    </ul>
                </div>
            </nav>
            <router-view></router-view>
        </div>

        <div v-else>
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loggedIn: false,
        };
    },
    created() {
        if (sessionStorage.getItem('api-token')) {
            this.loggedIn = true;
        }
        this.$appEvents.$on('customer-logon', () => {
            this.loggedIn = true;
        });
    },
};
</script>
