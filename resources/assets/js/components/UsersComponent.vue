<template>
    <ul>
        <li v-for="user in users">{{ `${user.first_name} ${user.last_name} (${user.email})` }}</li>
    </ul>
</template>
<script>
    export default {
        created() {
            axios.get('/api/users')
                .then((response) => {
                    this.users = response.data;
                })
                .catch(function (e) {
                    console.warn('Users are nor loaded');
                })
        },
        data() {
            return {
                users: []
            }
        }
    }
</script>