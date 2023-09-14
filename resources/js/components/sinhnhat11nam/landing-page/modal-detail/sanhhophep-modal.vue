<template>
    <div id="SanhHopHep-Modal">
      <!-- Nội dung modal ở đây -->
        <div class="main-list-ctvd">
            <div class="it-image-ctvd it-puzzle" :class="`itpuzzle`+(idx+1)" v-for="(it, idx) in 192" :key="idx">
                <!-- <span style="display: none;">{{checkInclude(listImageTram4, it)}}</span> -->
                <img :src="list_back[idx]['image']" :class="{'brightness-manhghep': dataPuzzle[idx] && dataPuzzle[idx].is_open == 1}">
            </div>
        </div>
    </div>
</template>

<script>
import {list_back} from '../script.js'
export default {
    
    props: {
        dataPuzzle: Array,
    },
    data(){
        return{
            list_back: list_back,
            // dataPuzzle: [],
        }
    },
    methods: {
        // getDataSanhTruongHopHep() {
            
        //     let self = this;
        //     axios.get('/api/get-data-sanh-truong-hop-hep', {
        //     })
        //         .then(function (response) {
        //             if (response.data.status === 200 && response.data.success == true) {
        //                 self.dataPuzzle = response.data.data ?? [];
        //                 console.log(self.dataPuzzle);
        //             }
        //         })
        //         .catch((error) => {
        //             console.log(error);
        //             if (error.response && error.response.status === 401) {
        //                 this.logoutSubmit()
        //             }
        //         })
        //         .finally();
        // },
    },
    created() {
        // this.getDataSanhTruongHopHep();
    },
};
</script>


<style>

#SanhHopHep-Modal .main-list-ctvd{
    display: grid;
    grid-template-columns: repeat(16, 1fr);
    width: 1024px;
    height: 576px;
    margin: 0 auto;
}

#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd{
    position: relative;
}


#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd:nth-child(-n+15) img {
    transform: translate(-50%, 0);
    top: 0;
}

#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle1 img {
    -webkit-transform: translate(0) !important;
    transform: translate(0) !important;
    top: 0;
    left: 0 !important;
}

#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd img {
    -ms-interpolation-mode: nearest-neighbor;
    image-rendering: -webkit-optimize-contrast;
    image-rendering: -moz-crisp-edges;
    image-rendering: -o-pixelated;
    image-rendering: pixelated;
    position: absolute;
    left: 48.7%;
    top: 54.7%;
    -webkit-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    opacity: 0.4;
}

#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle16 img{
    -webkit-transform: translate(0) !important;
    transform: translate(0) !important;
    top: 0;
    left: inherit;
    right: 0;
}

#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle17 img,
#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle33 img,
#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle49 img,
#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle65 img,
#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle81 img,
#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle97 img,
#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle113 img,
#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle129 img,
#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle145 img,
#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle161 img{
    left: 0;
    -webkit-transform: translate(0, -50%);
    transform: translate(0, -50%);
}

#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle32 img,
#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle64 img,
#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle96 img,
#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle128 img,
#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle160 img{
    left: 29.7%;
}

#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle177 img{
    top: inherit;
    left: 0;
    bottom: 0;
    -webkit-transform: translate(0);
    transform: translate(0);
}

#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle179 img,
#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle181 img,
#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle183 img,
#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle185 img,
#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle187 img,
#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle189 img,
#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle191 img{
    top: inherit;
    bottom: 0;
    -webkit-transform: translate(-50%, 0);
    transform: translate(-50%, 0);
}

#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle178 img,
#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle180 img,
#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle182 img,
#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle184 img,
#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle186 img,
#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle188 img,
#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle190 img{
    top: 49.7%;
}

#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle192 img{
    top: inherit;
    bottom: 0;
    -webkit-transform: translate(-50%, 0);
    transform: translate(-50%, 0);
    left: 30%;
}


.brightness-manhghep{
    opacity: 1 !important;
    filter: brightness(140%) !important;
}
</style>