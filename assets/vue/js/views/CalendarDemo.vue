
<template>
    <div>
        <div class="row col">
            <h1>Calendar Demo page</h1>
        </div>

        <div class="row col">
            <div class="col">
                <vue-cal></vue-cal>
            </div>
        </div>
    </div>
</template>

<script>
    import VueCal from 'vue-cal'
    import 'vue-cal/dist/vuecal.css'
    export default {
        name: "CalendarDemo",
        components: {
            'vue-cal': VueCal
        }
    };
</script>