import Vue from 'vue';
import axios from 'axios';

let queries = {
    registration: `mutation registration($customer: customerInput) {
        registration(customer: $customer)
    }`,

    login: `mutation login($customer: customerInput) {
        login(customer: $customer)
    }`,

    category: `{category{id,name}}`,

    checkcustomer: `query CheckCustomerQuery {
        checkcustomer
    }`,

    savecategory: `mutation savecategory($name: String, $id: String) {
        savecategory(name: $name, id: $id) {
            error,
            message
        }
    }`,

    category: `query fetchSingleCategory($category_id: String, $delete_category_id: String) {
        category(category_id: $category_id, delete_category_id: $delete_category_id) {
            id,
            name
        }
    }`,

    blogs: `query fetchSingleBlogs($blog_id: String, $delete_blog_id: String) {
        blogs(blog_id: $blog_id, delete_blog_id: $delete_blog_id) {
            id,
            title,
            description,
            customer_id,
            category_id,
            category {
                name
            }
        }
    }`,

    saveblogs: `mutation saveblogs($blog: blogInput) {
        saveblogs(blog: $blog) {
            error,
            message
        }
    }`,

    customer: `{customer{firstname,lastname, email}}`,

    updateProfile: `mutation updateProfile($file: Upload!, $customer: customerInput) {
        updateProfile(file: $file, customer: $customer) {
            error,
            message
        }
    }`,
};

let customerQueries = [
    'checkcustomer',
    'category',
    'savecategory',
    'blogs',
    'saveblogs',
    'customer',
    'updateProfile',
];

let uploadQueries = ['updateProfile'];

function getApiUrl(queryName) {
    let segment = '';
    if (customerQueries.some((q) => q === queryName)) {
        segment = '/customer';
    }
    return `graphql${segment}`;
}

Vue.prototype.$query = function (queryName, queryVariables) {
    var token = '';
    if (customerQueries.some((q) => q === queryName)) {
        token = sessionStorage.getItem('api_token');
    }

    if (uploadQueries.some((q) => q === queryName)) {
        var bodyFormData = new FormData();

        bodyFormData.set(
            'operations',
            JSON.stringify({
                // Mutation string
                query: queries[queryName],
                variables: queryVariables,
            })
        );
        bodyFormData.set('operationName', null);
        bodyFormData.set('map', JSON.stringify({ file: ['variables.file'] }));
        bodyFormData.append('file', queryVariables.file);

        let options = {
            url: getApiUrl(queryName),
            method: 'POST',
            data: bodyFormData,
        };

        if (token) {
            options.headers = {
                Authorization: `Bearer ${token}`,
                'Content-Type': 'multipart/form-data',
            };
        }
        return axios(options);
    } else {
        let options = {
            url: getApiUrl(queryName),
            method: 'POST',
            data: {
                query: queries[queryName],
            },
        };

        if (queryVariables) {
            options.data.variables = queryVariables;
        }

        if (token) {
            options.headers = {
                Authorization: `Bearer ${token}`,
            };
        }
        return axios(options);
    }
};
