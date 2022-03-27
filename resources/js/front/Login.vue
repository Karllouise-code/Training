<template>
    <div>
        <main class="form-signin">
            <form @submit.prevent="submitForm">
                <img class="mb-4" src="https://seeklogo.com/images/O/one-piece-logo-A80CEB54CC-seeklogo.com.png" alt="" width="150" height="55" />

                <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

                <div v-if="isLogin" class="alert alert-warning"><span class="spinner-border text-warning"></span> Please wait... validating your credentials</div>

                <div class="form-floating">
                    <input v-model="email" type="email" class="form-control" placeholder="Email address" />
                    <label for="email">Email address</label>
                    <div class="text-danger">{{ email_error }}</div>
                </div>

                <div class="form-floating">
                    <input v-model="password" type="password" class="form-control" placeholder="Password" />
                    <label for="password">Password</label>
                    <div class="text-danger">{{ password_error }}</div>
                </div>

                <button class="btn btn-lg btn-primary" type="submit">Sign in</button>
                <router-link to="/registration" class="btn btn-lg btn-primary">Register</router-link>
            </form>
        </main>
    </div>
</template>

<script>
export default {
    data() {
        return {
            email: "",
            password: "",
            email_error: "",
            password_error: "",
            isLogin: false,
        };
    },
    methods: {
        submitForm() {
            this.isLogin = true;
            this.$query("login", {
                customer: {
                    email: this.email,
                    password: this.password,
                },
            }).then((response) => {
                this.isLogin = false;
                if (response.data.errors) {
                    let errors = Object.values(response.data.errors[0].extensions.validation).flat();
                    let errors_keys = Object.keys(response.data.errors[0].extensions.validation).flat();
                    this.email_error = errors_keys.some((q) => q === "customer.email") ? errors[errors_keys.indexOf("customer.email")] : "";
                    this.password_error = errors_keys.some((q) => q === "customer.password") ? errors[errors_keys.indexOf("customer.password")] : "";
                } else {
                    let token = response.data.data.login;
                    if (token) {
                        sessionStorage.setItem("api-token", token);
                        this.$appEvents.$emit("customer-logon");
                        this.$router.push("/customer/dashboard");
                    } else {
                        this.$swal("Error!", "Invalid email or password", "error");
                    }
                }
            });
        },
    },
};
</script>
