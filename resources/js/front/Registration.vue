<template>
    <div>
        <main class="form-signin">
            <form @submit.prevent="submitForm">
                <img class="mb-4" src="https://seeklogo.com/images/O/one-piece-logo-A80CEB54CC-seeklogo.com.png" alt="" width="150" height="55" />
                <h1 class="h3 mb-3 fw-normal">Register</h1>

                <div v-if="isRegister" class="alert alert-warning"><span class="spinner-border text-warning"></span> Please wait... saving your registration</div>

                <label for="firstname" class="visually-hidden">First Name</label>
                <input v-model="firstname" type="text" class="form-control" placeholder="First name" />
                <div class="text-danger">{{ firstname_error }}</div>
                <label for="lastname" class="visually-hidden">Last Name</label>
                <input v-model="lastname" type="text" class="form-control" placeholder="Last name" />
                <div class="text-danger">{{ lastname_error }}</div>
                <label for="email" class="visually-hidden">Email address</label>
                <input v-model="email" type="email" class="form-control" placeholder="name@example.com" autofocus />
                <div class="text-danger">{{ email_error }}</div>
                <label for="password" class="visually-hidden">Password</label>
                <input v-model="password" type="password" class="form-control" placeholder="Password" />
                <div class="text-danger">{{ password_error }}</div>

                <button class="btn btn-lg btn-warning" type="submit">Register</button>
                <router-link class="btn btn-lg btn-default" to="/">Cancel</router-link>
            </form>
        </main>
    </div>
</template>

<script>
export default {
    data() {
        return {
            firstname: "",
            lastname: "",
            email: "",
            password: "",
            firstname_error: "",
            lastname_error: "",
            email_error: "",
            password_error: "",
            isRegister: false,
        };
    },

    methods: {
        submitForm() {
            this.$query("registration", {
                customer: {
                    firstname: this.firstname,
                    lastname: this.lastname,
                    email: this.email,
                    password: this.password,
                },
            }).then((response) => {
                if (response.data.errors) {
                    let errors = Object.values(response.data.errors[0].extensions.validation).flat();
                    let errors_keys = Object.keys(response.data.errors[0].extensions.validation).flat();
                    this.firstname_error = errors_keys.some((q) => q === "customer.firstname") ? errors[errors_keys.indexOf("customer.firstname")] : "";
                    this.lastname_error = errors_keys.some((q) => q === "customer.lastname") ? errors[errors_keys.indexOf("customer.lastname")] : "";
                    this.email_error = errors_keys.some((q) => q === "customer.email") ? errors[errors_keys.indexOf("customer.email")] : "";
                    this.password_error = errors_keys.some((q) => q === "customer.password") ? errors[errors_keys.indexOf("customer.password")] : "";
                } else {
                    this.isRegister = true;
                    setTimeout(() => {
                        this.$swal("Success!", "Your registration was successful. Click the login button to login", "success");
                    }, 2000);
                    this.clearFields();
                    setTimeout(() => {
                        this.isRegister = false;
                    }, 2000);
                }
            });
        },
        clearFields() {
            (this.firstname = ""), (this.lastname = ""), (this.email = ""), (this.password = ""), (this.firstname_error = ""), (this.lastname_error = ""), (this.email_error = ""), (this.password_error = "");
        },
    },
};
</script>
