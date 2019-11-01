<template>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <router-link
                    class="navbar-brand"
                    to="/"
            >
                App
            </router-link>
            <button
                    class="navbar-toggler"
                    type="button"
                    data-toggle="collapse"
                    data-target="#navbarNav"
                    aria-controls="navbarNav"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon" />
            </button>
            <div
                    id="navbarNav"
                    class="collapse navbar-collapse"
            >
                <ul class="navbar-nav">
                    <router-link
                            class="nav-item"
                            tag="li"
                            to="/"
                            active-class="active"
                    >
                        <a class="nav-link">Home</a>
                    </router-link>
                </ul>
                <router-link
                        class="nav-item"
                        tag="li"
                        to="/alpha"
                        active-class="active"
                >
                    <a class="nav-link">Alpha</a>
                </router-link>

            </div>
        </nav>

        <router-view />
    </div>
</template>

<script>
    export default {
        name: "App"
    };
</script>