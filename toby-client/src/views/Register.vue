<template>
  <div
    class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8 bg-white"
  >
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <img
        class="mx-auto h-10 w-auto"
        src="../assets/tobyicon.png"
        alt="Your Company"
      />
      <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight">
        Sign up to your account
      </h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form class="space-y-6" @submit.prevent="registerUser">
        <div>
          <label for="Name" class="block text-sm font-medium leading-6"
            >User Name</label
          >
          <div class="mt-2">
            <input
              id="Name"
              name="Name"
              type="Name"
              autocomplete="Name"
              v-model="form.name"
              required
              class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
            />
          </div>
        </div>
        <div>
          <label for="email" class="block text-sm font-medium leading-6"
            >Email address</label
          >
          <div class="mt-2">
            <input
              id="email"
              name="email"
              type="email"
              autocomplete="email"
              v-model="form.email"
              required
              class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
            />
          </div>
        </div>

        <div>
          <div class="flex items-center justify-between">
            <label for="password" class="block text-sm font-medium leading-6"
              >Password</label
            >
          </div>
          <div class="mt-2">
            <input
              id="password"
              name="password"
              type="password"
              autocomplete="current-password"
              v-model="form.password"
              required
              class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
            />
          </div>
        </div>

        <div>
          <button
            type="submit"
            :disabled="isSubmitting"
            class="flex w-full justify-center rounded-md bg-pink-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-pink-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
          >
            <span v-if="isSubmitting">Submitting...</span>
            <span v-else>Sign up</span>
          </button>
        </div>
      </form>

      <p class="mt-10 text-center text-sm text-gray-500">
        Have already account ?

        <router-link
          to="/login"
          class="font-semibold leading-6 text-pink-600 hover:text-pink-500"
        >
          Login
        </router-link>
      </p>
    </div>
  </div>
</template>

<script>
  import axios from 'axios';

  export default {
    data() {
      return {
        form: {
          name: '',
          email: '',
          password: '',
        },
        isSubmitting: false, // Track form submission status
      };
    },
    methods: {
      async registerUser() {
        this.isSubmitting = true; // Set loading state to true when submission starts
        try {
          const response = await axios.post(
            'http://localhost:8000/api/register',
            this.form,
            {
              headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
              },
            },
          );
          alert('User was successfully Register');
          // Redirect to login page after successful registration
          this.$router.push('/login');
        } catch (error) {
          // Check if there is a response from the server
          if (error.response) {
            // The request was made, but the server responded with a status code outside of 2xx
            alert(
              `Error: ${error.response.data.error || 'Registration failed'}`,
            );
          } else if (error.request) {
            // The request was made, but no response was received
            alert('No response received from the server.');
            console.error('No response received:', error.request);
          } else {
            // Something else caused the error
            alert(`Error: ${error.message}`);
            console.error('Error:', error.message);
          }
        } finally {
          this.isSubmitting = false; // Reset the loading state
        }
        this.isSubmitting = false;
      },
    },
  };
</script>
