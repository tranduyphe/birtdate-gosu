<template>
    <div id="ThuVien-Modal">
      <ThuVienToanTri :attrKimcuong="attrKimcuong" @updateAttrKimcuongNtd="updateAttrKimcuongNtd" 
            :attrLongvu="attrLongvu" @updateAttrLongvuNtd="updateAttrLongvuNtd"></ThuVienToanTri>
    </div>
</template>

<script>
import ThuVienToanTri from '../../../home/ThuVienToanTri.vue';
export default {
    props: {
        attrKimcuong: Number,
        attrLongvu: Number,
    },
    components: {
        ThuVienToanTri
    },
    data() {
        return {

            lineBrealimg: '/images/sinhnhat11nam/img_main/line-break.png',
        }
    },
    methods: {
        updateAttrKimcuongNtd(newValue) {
            console.log("updateAttrKimcuongNtd newValue", newValue);
            // Cập nhật giá trị của attrKimcuong từ sự kiện
            this.$emit("updateAttrKimcuong", newValue);
        },
        updateAttrLongvuNtd(newValue) {
            console.log("updateAttrLongvuNtd newValue", newValue);
            // Cập nhật giá trị của attrKimcuong từ sự kiện
            this.$emit("updateAttrLongvu", newValue);
        },
    },
};
</script>

<style>

</style>
  