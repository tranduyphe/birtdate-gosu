<template>
    <div id="NhaThiDau-Modal">
        <!-- Nội dung modal ở đây -->
        <ThuVienToanTri2 :attrKimcuong="attrKimcuong" @updateAttrKimcuongNtd="updateAttrKimcuongNtd" 
            :attrLongvu="attrLongvu" @updateAttrLongvuNtd="updateAttrLongvuNtd"></ThuVienToanTri2>
    </div>
</template>

<script>
import ThuVienToanTri2 from '../../../home/ThuVienToanTri2.vue';
export default {
    props: {
        attrKimcuong: Number,
        attrLongvu: Number,
    },
    components: {
        ThuVienToanTri2
    },
    data() {
        return {
            itemRed: '/images/sinhnhat11nam/img_main/thuvien-itemRed.png',
            itemYellow: '/images/sinhnhat11nam/img_main/thuvien-itemYellow.png',
            itemPuple: '/images/sinhnhat11nam/img_main/thuvien-itemPuple.png',
            lineBrealimg: '/images/sinhnhat11nam/img_main/line-break.png',
        }
    },
    created() {

    },
    methods: {
        updateAttrKimcuongNtd(newValue) {
            // Cập nhật giá trị của attrKimcuong từ sự kiện
            this.$emit("updateAttrKimcuong", newValue);
        },
        updateAttrLongvuNtd(newValue) {
            // Cập nhật giá trị của attrKimcuong từ sự kiện
            this.$emit("updateAttrLongvu", newValue);
        },
    },
};
</script>

<style>
.cell-wait p {
    color: #e7ca8e;
}

.cell-wait span {
    background-color: #292929;
    color: white;
}
</style>