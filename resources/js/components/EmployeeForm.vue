<template>
    <div>
        <h1>Add Employee</h1>
        <form @submit.prevent="submitForm">
            <input v-model="name" placeholder="Employee Name" />
            <button type="submit">Submit</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return { name: "" };
    },
    methods: {
        submitForm() {
            console.log("Employee Name:", this.name);
        },
    },
};
</script>
