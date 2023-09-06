<script>
export default {
    components: {
    }, 
    data: () => {
        return {}
    },
    computed: {
    },
    methods: {
        // ...authMethods,
        // async signOut(){
        //     console.log("signOut");
        //     await this.logout();
        // }
    },
    created: () => {
    },
    mounted: () =>{    
    },
};
</script>
<template>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#headerMenu" aria-controls="headerMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="headerMenu">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 justify-content-end w-100">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Bách nhật</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">GOSU Corp</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">S20</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Facebook</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>