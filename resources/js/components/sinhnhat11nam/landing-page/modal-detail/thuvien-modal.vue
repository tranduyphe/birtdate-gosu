<template>
    <div id="ThuVien-Modal">
      <miniGame></miniGame>
    </div>
</template>

<!-- <div class="row justify-content-center align-items-center">
    <div v-for="item in arrayItems" class="cell d-flex justify-content-center align-items-center">
        <img :src="item.item" alt="" width="52" height="60">
    </div>
  </div>
  <div class="line-break text-center">
    <img :src="lineBrealimg" alt="">
  </div>
  <div class="cell-wait">
    <p class="font-size-13">Số ô chờ đã fill/số ô chờ tổng&nbsp;<span class="p-1">3/6</span></p>
  </div> -->

<script>
import miniGame from '../../../home/Minigame.vue';
export default {
    components: {
        miniGame
    },
    data() {
        return {
            itemRed: '/images/sinhnhat11nam/img_main/thuvien-itemRed.png',
            itemYellow: '/images/sinhnhat11nam/img_main/thuvien-itemYellow.png',
            itemPuple:'/images/sinhnhat11nam/img_main/thuvien-itemPuple.png',
            lineBrealimg: '/images/sinhnhat11nam/img_main/line-break.png',
            arrayItems: [
                {item: '/images/sinhnhat11nam/img_main/thuvien-itemRed.png'},
                {item: '/images/sinhnhat11nam/img_main/thuvien-itemYellow.png'},
                {item: '/images/sinhnhat11nam/img_main/thuvien-itemPuple.png'},
                {item: '/images/sinhnhat11nam/img_main/thuvien-itemYellow.png'},
                {item: '/images/sinhnhat11nam/img_main/thuvien-itemRed.png'},
                {item: '/images/sinhnhat11nam/img_main/thuvien-itemYellow.png'},
                {item: '/images/sinhnhat11nam/img_main/thuvien-itemPuple.png'},
                {item: '/images/sinhnhat11nam/img_main/thuvien-itemYellow.png'},
                {item: '/images/sinhnhat11nam/img_main/thuvien-itemRed.png'},
                {item: '/images/sinhnhat11nam/img_main/thuvien-itemYellow.png'},
                {item: '/images/sinhnhat11nam/img_main/thuvien-itemPuple.png'},
                {item: '/images/sinhnhat11nam/img_main/thuvien-itemYellow.png'},
                {item: '/images/sinhnhat11nam/img_main/thuvien-itemPuple.png'},
                {item: '/images/sinhnhat11nam/img_main/thuvien-itemYellow.png'},
                {item: '/images/sinhnhat11nam/img_main/thuvien-itemRed.png'},
                {item: '/images/sinhnhat11nam/img_main/thuvien-itemYellow.png'},
                {item: '/images/sinhnhat11nam/img_main/thuvien-itemPuple.png'},
                {item: '/images/sinhnhat11nam/img_main/thuvien-itemYellow.png'},
                {item: '/images/sinhnhat11nam/img_main/thuvien-itemRed.png'},
                {item: '/images/sinhnhat11nam/img_main/thuvien-itemYellow.png'},
                {item: '/images/sinhnhat11nam/img_main/thuvien-itemPuple.png'},
                {item: '/images/sinhnhat11nam/img_main/thuvien-itemYellow.png'},
                {item: '/images/sinhnhat11nam/img_main/thuvien-itemRed.png'},
                {item: '/images/sinhnhat11nam/img_main/thuvien-itemYellow.png'},
                {item: '/images/sinhnhat11nam/img_main/thuvien-itemPuple.png'},
                {item: '/images/sinhnhat11nam/img_main/thuvien-itemYellow.png'},
                {item: '/images/sinhnhat11nam/img_main/thuvien-itemRed.png'},
                {item: '/images/sinhnhat11nam/img_main/thuvien-itemYellow.png'},
                {item: '/images/sinhnhat11nam/img_main/thuvien-itemPuple.png'},
                {item: '/images/sinhnhat11nam/img_main/thuvien-itemYellow.png'},
            ],
        }
    },
    methods: {
        
    },
};
</script>

<style>
/* #ThuVien-Modal .cell{
    background:
        linear-gradient(to bottom, #292929, #453d69) padding-box, 
        linear-gradient(to bottom, #7b5d1c, #a1813f) border-box;
    padding: 10px;
    border: 1px solid transparent;
    border-radius: 5px;
    display: inline-block;
    max-width: 75px;
    width: 100%;
    height: 75px;
    margin-right: 20px;
    margin-bottom: 20px;
} */

.cell-wait p{
    color: #e7ca8e;
}

.cell-wait span{
    background-color: #292929;
    color: white;
}
</style>
  