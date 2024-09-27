<template>
  <div
    class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8 "
  >
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <img
        class="mx-auto h-10 w-auto"
        src="../assets/tobyicon.png"
        alt="Your Company"
      />
      <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight">
        Sign in to your account
      </h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form @submit.prevent="loginUser" class="space-y-6">
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
              class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
            />
          </div>
        </div>

        <div>
          <button
            type="submit"
            :disabled="isSubmitting"
            class="flex w-full justify-center rounded-md hover:opacity-80 bg-pink-600 border-pink-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
          >
            <span v-if="isSubmitting">Logging in...</span>
            <span v-else>Login</span>
          </button>
        </div>
      </form>

      <p class="mt-10 text-center text-sm text-gray-500">
        Don't have account ?
        <router-link
          to="/register"
          class="font-semibold leading-6 text-pink-600 hover:text-pink-500"
        >
          Register
        </router-link>
      </p>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      form: {
        email: "",
        password: "",
      },
      isSubmitting: false, // Track login status
    };
  },
  methods: {
    async loginUser() {
      this.isSubmitting = true; // Disable form and show "Logging in..." text

      try {
        const response = await axios.post(
          "http://localhost:8000/api/login",
          this.form,
          {
            headers: {
              Accept: "application/json",
              "Content-Type": "application/json",
            },
          }
        );

        // Store the access_token in localStorage
        const token = response.data.data.access_token;
        const email = response.data.data.email;
        localStorage.setItem("accessToken", token);
        localStorage.setItem("User Email", email);
        alert(response.data.message);
        this.$router.push("/");
        console.log("Login successful:", response.data);

        // Handle successful login, e.g., save token and redirect
        // For example:
        // localStorage.setItem('authToken', response.data.token);
        // this.$router.push('/dashboard');
      } catch (error) {
        // Check if the error response exists
        if (error.response) {
          // Server responded with a status other than 2xx
          alert(
            `Login failed: ${
              error.response.data.message || "Invalid email or password"
            }`
          );
          console.error("Login error:", error.response.data);
        } else if (error.request) {
          // Request was made but no response was received
          alert("No response from the server. Please try again later.");
          console.error("No response received:", error.request);
        } else {
          // Other types of errors (e.g., client-side errors)
          alert(`Error: ${error.message}`);
          console.error("Error:", error.message);
        }
      } finally {
        this.isSubmitting = false; // Re-enable the form
      }
      this.isSubmitting = false;
    },
  },
};
</script>

<style></style>
