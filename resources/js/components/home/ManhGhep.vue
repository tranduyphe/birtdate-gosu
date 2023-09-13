<template>
    <div class="puzzle-container">
        <div class="puzzle-piece" v-for="(data, index) in dataPuzzle" :key="index" :style="{
            width: '50px',
            height: '50px',
            left: ((index) % 18) * 50 + 'px',
            top: Math.floor((index) / 18) * 50 + 'px',
            backgroundColor: data.is_open === 1 ? 'none' : 'blue',
            border: data.is_open === 0 ? '2px solid black' : 'none'
        }">
            <!-- Nội dung của mỗi piece -->
        </div>
    </div>
</template>
<script>
export default { 
    data() {
        return {
            dataPuzzle: [],
        };
    },

    created() {
        this.getDataSanhTruongHopHep();
    },
    methods: {
        getDataSanhTruongHopHep() {
            let self = this;
            axios.get('/api/get-data-sanh-truong-hop-hep', {
            })
                .then(function (response) {
                    if (response.data.status === 200 && response.data.success == true) {
                        self.dataPuzzle = response.data.data ?? [];
                        console.log("self.data", self.data[0].is_open);
                    }
                })
                .catch((error) => {
                    console.log(error);
                    if (error.response && error.response.status === 401) {
                        this.logoutSubmit()
                    }
                })
                .finally();
        },
    },
};
</script>
  
<style scoped>
.puzzle-container {
    position: relative;
    width: 900px;
    /* Điều chỉnh kích thước cho phù hợp với bức ảnh ghép */
    height: 550px;
    background-image: url('/images/sinhnhat11nam/img_main/nha-thi-dau.png');
    background-size: cover;
    border: 1px solid #ccc;
}

.puzzle-piece {
    position: absolute;
    cursor: pointer;
    /* background-color: blue; */
    width: 100px;
    height: 50px;
    z-index: 0;

}

.puzzle-piece img {
    width: 100px;
    /* Điều chỉnh kích thước cho phù hợp với mảnh ghép */
    height: 50px;
}
</style>
  