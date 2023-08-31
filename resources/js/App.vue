<script>
import Header from './components/layouts/Header';
import Footer from './components/layouts/Footer';
export default {
    components: {Header, Footer},
    data() {},
    computed: {
    },
    methods: {
    },
    created: () => {       
    },
    mounted: async () =>{
        // let data = await axios
        //         .post('/api/login', {
        //             email: 'phe.tran@gosu.vn',
        //             password: 'duyphe123!@#',
        //         });
        // if(data.status == 200){
        //     data = data.data;
        //     sessionStorage.setItem("author", JSON.stringify(data.data));
        // }
        // console.log('data');
        // console.log(data);
        // let dataAuthor = sessionStorage.getItem("author");
        // if (dataAuthor) {
        //     dataAuthor = JSON.parse(dataAuthor);
        // }
        //console.log(dataAuthor);
        // let header = {
        //     'Content-Type': 'application/json',
        //     'Accept': 'application/json',
        //     'Authorization': 'Bearer '+dataAuthor.token,
        // }
        // //let data = await axios.post('/api/logout', header);
        // let data = await axios
        //         .post('/api/post', header);
        // console.log('data');
        // console.log(data);
    }
}
</script>
<template>
    <Header></Header>
    <router-view></router-view>
    <Footer></Footer>
</template>