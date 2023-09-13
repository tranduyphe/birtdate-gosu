<template>
    <div id="SanhHopHep-Modal">
      <!-- Nội dung modal ở đây -->
        <div class="main-list-ctvd">
            <div class="it-image-ctvd it-puzzle" :class="`itpuzzle`+(idx+1)" v-for="(it, idx) in 16" :key="idx">
                <!-- <span style="display: none;">{{checkInclude(listImageTram4, it)}}</span> -->
                <img :src="list_back[idx]['image']" >
            </div>
        </div>
    </div>
</template>

:class="`itpuzzle`+(idx+1)" v-for="(it, idx)



<script>
import {list_back} from '../script.js'
export default {
    data(){
        return{
            list_back: list_back,
        }
    },
    methods: {
        
    },
    created(){
        console.log(list_back);
    }
};
</script>


<style>

#SanhHopHep-Modal .main-list-ctvd{
    display: grid;
    grid-template-columns: repeat(16, 1fr);
    width: 100%;
    height: 500px;
}

#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd{
    position: relative;
}


#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd:nth-child(-n+15) img {
    transform: translate(-10%, 0);
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
    left: 121.7%;
    top: 49.7%;
    -webkit-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
}

#SanhHopHep-Modal .main-list-ctvd .it-image-ctvd.itpuzzle16 img {
    -webkit-transform: translate(0) !important;
    transform: translate(0) !important;
    top: 0;
    left: inherit;
    right: 2px;
}
</style>