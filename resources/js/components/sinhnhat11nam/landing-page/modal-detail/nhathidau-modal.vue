<template>
    <div id="NhaThiDau-Modal">
      <!-- Nội dung modal ở đây -->
      <miniGame></miniGame>
    </div>
</template>

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
        }
    },
    methods: {
        
    },
};
</script>

<style>

.cell-wait p{
    color: #e7ca8e;
}

.cell-wait span{
    background-color: #292929;
    color: white;
}
</style>