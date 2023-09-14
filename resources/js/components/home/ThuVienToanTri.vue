<template>
    <div class="thuvientoantri container" v-if="flipList != nul">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-evenly">
                <div class="row-card" v-for="col in 8" :key="col" data-aos="zoom-in-up">
                    <div class="cell-card mb-3" v-for="row in 4" :key="row">
                        <div class="card" @click="flipCard((row - 1) * 8 + col - 1)"
                            :style="{ backgroundColor: flipList[(row - 1) * 8 + col - 1].color }">
                            <img :src="flipList[(row - 1) * 8 + col - 1].color" alt="" width="65" height="65">
                        </div>
                    </div>
                </div>
            </div>

            <div class="line-break text-center my-3">
                <img :src="lineBrealimg" alt="">
            </div>
            <div class="col-md-8">
                <p style="margin-top: 0pt; margin-bottom: 14pt; text-align: justify; font-size: 16pt; line-height: 1;"><b><span style="text-align: left; color: rgb(0, 0, 0); font-size: 18px;">Tỉ lệ trước khi user tr&uacute;ng Thẻ Tiềm Long</span></b></p>
                <ul>
                    <li style="margin-top: 0pt; margin-bottom: 14pt; text-align: justify; font-size: 16px; color: rgb(0, 0, 0); line-height: 1;"><span style="text-align: left;">T&iacute;m: 1 Thẻ Tiềm Long (1 người chỉ nhận 1 lần duy nhất) (30%)</span></li>
                    <li style="margin-top: 0pt; margin-bottom: 14pt; text-align: justify; font-size: 16px; color: rgb(0, 0, 0); line-height: 1;"><span style="text-align: left;">Đỏ: L&ocirc;ng Phượng Ho&agrave;ng*5 (10%)</span></li>
                    <li style="margin-top: 0pt; margin-bottom: 14pt; text-align: justify; font-size: 16px; color: rgb(0, 0, 0); line-height: 1;"><span style="text-align: left;">Xanh l&aacute;: Đ&aacute; Mặt Trăng*10 (10%)</span></li>
                    <li style="margin-top: 0pt; margin-bottom: 14pt; text-align: justify; font-size: 16px; color: rgb(0, 0, 0); line-height: 1;"><span style="text-align: left;">V&agrave;ng &amp; Hồng: Fail (25%+25%)</span></li>
                </ul>
                <p style="margin-top: 0pt; margin-bottom: 14pt; text-align: justify; font-size: 16pt; line-height: 1;"><span style="text-align: left; color: rgb(0, 0, 0); font-size: 18px;"><strong>Tỉ lệ sau khi user đ&atilde; tr&uacute;ng Thẻ Tiềm Long</strong></span></p>
                <ul>
                    <li style="margin-top: 0pt; margin-bottom: 14pt; text-align: justify; font-size: 16pt; color: rgb(0, 0, 0); line-height: 1;"><span style="text-align: left; font-size: 15px;">Đỏ: L&ocirc;ng Phượng Ho&agrave;ng*5 (20%)</span></li>
                    <li style="margin-top: 0pt; margin-bottom: 14pt; text-align: justify; font-size: 16pt; color: rgb(0, 0, 0); line-height: 1;"><span style="text-align: left; font-size: 15px;">Xanh l&aacute;: Đ&aacute; Mặt Trăng*10 (20%)</span></li>
                    <li style="margin-top: 0pt; margin-bottom: 14pt; text-align: justify; font-size: 16pt; color: rgb(0, 0, 0); line-height: 1;"><span style="text-align: left; font-size: 15px;">V&agrave;ng &amp; Hồng: Fail (30%+30%)</span></li>
                </ul>
            </div>
            <div class="attribute-items d-flex col-md-4 justify-content-around align-items-end">
                <div class="div-img items thongbao mr-5" data-aos="fade-down">
                    <img :src="thongbaoimgUrl" alt="Thông báo" width="">
                    <span class="font-size-14 text-white">{{ attrThongbao }}</span>
                </div>
                <div class="div-img items kimcuong mr-5" data-aos="fade-down">
                    <img :src="kimcuongimgUrl" alt="Thông báo" width="">
                    <span class="font-size-14 text-white">{{ attrKimcuong }}</span>
                </div>
                <div class="div-img items longvu" data-aos="fade-down">
                    <img :src="longvuimgUrl" alt="Thông báo" width="">
                    <span class="font-size-14 text-white">{{ attrLongvu }}</span>
                </div>
            </div>
        </div>
    </div>
</template>
  
<script>
import { mapGetters, mapMutations, mapActions } from "vuex";
import Vue from 'vue';
import { store } from '../../store/store';
// Tạo kết nối Socket.io
// import io from "socket.io-client";
export default {
    props: {
        attrKimcuong:Number,
        attrLongvu:Number,
    },
    data() {
        return {
            socket: null,
            pageConnected: true,
            accessToken: "", // Khởi tạo access token rỗng
            colors: ['/images/sinhnhat11nam/img_main/thuvien-itemRed.png', '/images/sinhnhat11nam/img_main/thuvien-itemYellow.png', '/images/sinhnhat11nam/img_main/thuvien-itemPuple.png', '/images/sinhnhat11nam/img_main/thuvien-itemPink.png', '/images/sinhnhat11nam/img_main/thuvien-itemGreen.png'],
            // flipList: new Array(33).fill({ active: false, color: '' }), // Tạo mảng 9 phần tử với giá trị ban đầu là false
            flipList: [],
            flag: false,
            attrThongbao: 0,
            lineBrealimg: '/images/sinhnhat11nam/img_main/line-break.png',
            thongbaoimgUrl: '/images/sinhnhat11nam/img_main/thongbao.png',
            kimcuongimgUrl: '/images/sinhnhat11nam/img_main/kimcuong.png',
            longvuimgUrl: '/images/sinhnhat11nam/img_main/longvu.png',
            itemRed: '/images/sinhnhat11nam/img_main/thuvien-itemRed.png',
            itemYellow: '/images/sinhnhat11nam/img_main/thuvien-itemYellow.png',
            itemPuple: '/images/sinhnhat11nam/img_main/thuvien-itemPuple.png',
            itemGreen: '/images/sinhnhat11nam/img_main/thuvien-itemGreen.png',
            itemPink: '/images/sinhnhat11nam/img_main/thuvien-itemPink.png',
        };
    },
    created() {
        this.getFlip();
    },
    methods: {
        ...mapActions(["saveInfoUser", "saveGameId"]),
        getFlip() {
            this.flipList = [];
            for (let i = 0; i < 32; i++) {
                const randomColor = this.colors[Math.floor(Math.random() * this.colors.length)];
                this.flipList.push({ active: 1, color: randomColor });
            }
        },
        flipCard(index) {
            this.flag = true;
            if (this.attrKimcuong < 5) {
                alert("Đá mặt trăng không đủ");
                this.flag = false;
            } else {
                // alert("Đá mặt trăng -5");
                const formData = new FormData();
                let self = this;
                // const csrfToken = 'sai_csrf_token';
                // axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
                axios.post('/api/active-flip-tvtt', formData, {
                })
                    .then(function (response) {
                        if (response.data.status === 200) {

                            if (response.data.success == true) {
                                if (response.data.data.user) {
                                    self.$emit("updateAttrKimcuongNtd", response.data.data.user.diamond);
                                    self.$emit("updateAttrLongvuNtd", response.data.data.user.feathers);
                                }
                                if (response.data.data.reward) {
                                    let reward = response.data.data.reward;
                                    let user = response.data.data.user.name;
                                    let message = "";
                                    if (reward.length == 0) {
                                        message = "Chúc bạn may mắn lần sau";
                                    } else {
                                        for (let i = 0; i < reward.length; i++) {

                                            if (reward[i].item_id == "1") {
                                                message = message + "Chúc mừng " + user + " đã nhận được " + reward[i].record + " LÔNG PHƯỢNG HOÀNG";
                                                }
                                            if (reward[i].item_id == "2") {
                                                message = message + "Chúc mừng " + user + " đã nhận được " + reward[i].record + " ĐÁ MẶT TRĂNG";
                                            }

                                            if (reward[i].item_id == "3") {
                                                message = message + " Thẻ tiềm long +" + reward[i].record;
                                            }
                                        }
                                        // alert(message);
                                        
                                    }
                                    self.$swal.fire({
                                            position: "center",
                                            icon: "success",
                                            title: message,
                                            showConfirmButton: false,
                                            timer: 3000,
                                            customClass: 'swal-wide',
                                        });
                                        self.getFlip();
                                        self.flag = false;
                                } else {
                                    // alert(response.data.message);
                                    self.$swal.fire({
                                            position: "center",
                                            icon: "success",
                                            title: response.data.message,
                                            showConfirmButton: false,
                                            timer: 5000
                                        });
                                        self.getFlip();
                                        self.flag = false;
                                }
                            } else {
                                self.flag = false;
                            }
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                        if (error.response && error.response.status === 401) {
                            this.logoutSubmit()
                        }
                    })
                    .finally();
            }
        }
    },
    // code test keyboard
    watch: {

    },
    computed: {
        // cardBackgroundColor() {
        //     return (col) => {
        //         if (this.waiting[col] === 1) {
        //             return 'blue';
        //         } else if (this.waiting[col] === 2) {
        //             return 'red';
        //         } else if (this.waiting[col] === 3) {
        //             return 'green';
        //         } else if (this.waiting[col] === 4) {
        //             return 'pink';

        //         } else if (this.waiting[col] === 5) {
        //             return 'orange';

        //         } else {
        //             return '';
        //         }
        //     };
        // }
    },
    mounted() {
        // Lắng nghe sự kiện storage để cập nhật tên người dùng từ tab khác
        // window.addEventListener('storage', (event) => {
        //     console.log("check event key storage:", event.key);
        //     alert("bạn đang thao tác ở page khác");
        // });
        // this.socket = io('localhost:3000');
        // console.log('Socket đã được khởi tạo', this.socket);

        // this.socket.on('connect', () => {
        //     console.log('Kết nối thành công với máy chủ socket');

        //     // Kiểm tra xem người dùng đã kết nối lần nào chưa
        //     // Gửi thông tin người dùng kèm theo
        //     const userId = this.UserInfo.id; // Thay bằng thông tin thực tế
        //     const pageConnected = this.pageConnected;
        //     console.log("check userId:", userId);
        //     console.log("check pageConnected:", pageConnected);
        //     this.socket.emit('userConnected', { userId, pageConnected });

        //     // Xử lý các sự kiện và gửi thông báo đến người dùng
        //     // ...
        // });
        // this.socket.on('disconnect', () => {
        //     this.pageConnected = false;
        //     // set 200ms để trường hợp f5 reload không bị hiện popup
        //     setTimeout(() => {
        //         this.$swal.fire({
        //             icon: "info",
        //             title: "Thông báo",
        //             text: "Kết nối socket thất bại",
        //             allowOutsideClick: false,
        //             confirmButtonText: "Kết nối lại",
        //         }).then((result) => {
        //             if (result.isConfirmed) {
        //                 this.reconnect();
        //             }
        //         });
        //     }, 200); // Chờ 500ms (0.5 giây) trước khi hiển thị popup
        // });

        // this.socket.on("notification", (data) => {
        //     this.pageConnected = false;
        //     console.log("Giá trị được gửi về từ sự kiện notification:", data);
        //     this.$swal.fire({
        //         icon: "info",
        //         title: "Thông báo",
        //         text: "Bạn đang thao tác ở page khác",
        //         allowOutsideClick: false, // Chặn nhấp vào vùng ngoài popup để tắt
        //         confirmButtonText: "Kết nối lại", // Tùy chọn tên nút confirm
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             this.reconnect();
        //         }
        //     });
        // });
    },
};
</script>

<style>
.card {
    width: 40px;
    height: 40px;
    perspective: 1000px;
    position: relative;
    transform-style: preserve-3d;
    transition: transform 0.3s linear;
}

.flipped {
    transform: rotateY(180deg);
}

.thuvientoantri .card:hover {
    filter: brightness(140%);
}

/* Thêm các hiệu ứng CSS keyframes animation tại đây */

/* ... CSS trước đó ... */

@keyframes flip {
    from {
        transform: rotateY(0deg);
    }

    to {
        transform: rotateY(180deg);
    }
}

.flipped {
    animation: flip 0.5s;
}

/* ... CSS sau đó ... */
</style>
