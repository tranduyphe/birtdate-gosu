<template>
    <div class="custom-cusor" >
      <img :src="imgDuaPhep" class="img-dua" id="img-dua" width="100" style="opacity: 0;">
    </div>
    <div class="game-thuvientoantri">
        <button class="btn-start" @click="reloadFlip()">Làm mới</button>
        <p class="text-center text-white" v-if="checkGameOver">Bạn đã thua cuộc, vui lòng "Làm mới" để tiếp tục (Trừ 5 đá
            mặt trăng)</p>
        <div class="row justify-content-center align-items-center">
            <div class="minigame-thuvien">
                <div class="" v-if="flipList != nul">
                    <div v-for="row in 3" :key="row" class="row justify-content-center align-items-center"
                        data-aos="fade-up">
                        <div v-for="col in 8" :key="col" class="cell p-0">
                            <div v-if="flipList[(row - 1) * 8 + col - 1]" class="card mb-0"
                                :class="{ flipped: flipList[(row - 1) * 8 + col - 1].active > 0, }"
                                @click="flipCard((row - 1) * 8 + col - 1)"
                                :style="{ opacity: flipList[(row - 1) * 8 + col - 1].active == 2 ? '0' : '1' }">
                                <div class="image">
                                    <img data-aos="fade-up"
                                        :src="flipList[(row - 1) * 8 + col - 1].color == null ? imgtransparent : flipList[(row - 1) * 8 + col - 1].color"
                                        alt="" width="65" height="65">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="line-break text-center my-3">
                <img :src="lineBrealimg" alt="">
            </div>
            <div class="col-md-4 text-center">
                <img :src="imgthuvien" width="200">
            </div>
            <div class="col-md-4">
                <p style="margin-top: 0pt; margin-bottom: 14pt; text-align: justify; font-size: 16pt; line-height: 1;"><b><span style="text-align: left; color: rgb(255, 255, 255); font-size: 18px;">(*) Cần tốn 5 Đá Mặt Trăng cho 1 lần mở ô.</span></b></p>
            </div>
            <div class="attribute-items mt-4 d-flex col-md-4 justify-content-around align-items-end">
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

<!-- <div class="front">
</div>
<div v-if="flipList[(row - 1) * 15 + col - 1].active == 1" 
    :style="{ background: flipList[(row - 1) * 15 + col - 1].color }">
</div>
<div v-else-if="flipList[(row - 1) * 15 + col - 1].active == 2" class="back" :style="{ background: 'black'}">
    <p>1</p>
</div> -->

<script>
import {
    authGetters,
    authMethods,
} from "@/store/store";
// Tạo kết nối Socket.io
// import io from "socket.io-client";
export default {
    props: {
        attrKimcuong: Number,
        attrLongvu: Number,
    },
    data() {
        return {
            socket: null,
            pageConnected: true,
            accessToken: "", // Khởi tạo access token rỗng
            colors: ['blue', 'red', 'green', 'pink'],
            // flipList: new Array(33).fill({ active: false, color: '' }), // Tạo mảng 9 phần tử với giá trị ban đầu là false
            flipList: [],
            flag: false,
            diamond: 0,
            feathers: 0,
            lineBrealimg: '/images/sinhnhat11nam/img_main/line-break.png',
            thongbaoimgUrl: '/images/sinhnhat11nam/img_main/thongbao.png',
            kimcuongimgUrl: '/images/sinhnhat11nam/img_main/kimcuong.png',
            longvuimgUrl: '/images/sinhnhat11nam/img_main/longvu.png',
            attrThongbao: 0,
            itemRed: '/images/sinhnhat11nam/img_main/thuvien-itemRed.png',
            itemYellow: '/images/sinhnhat11nam/img_main/thuvien-itemYellow.png',
            itemPuple: '/images/sinhnhat11nam/img_main/thuvien-itemPuple.png',
            itemGreen: '/images/sinhnhat11nam/img_main/thuvien-itemGreen.png',
            itemPink: '/images/sinhnhat11nam/img_main/thuvien-itemPink.png',
            imgtransparent: '/images/sinhnhat11nam/img_main/transparent.png',
            imgloser: '/images/sinhnhat11nam/img_main/loser.png',
            imgPopUpQua: '/images/sinhnhat11nam/img_main/popup-qua.png',
            iconLongvu: '/images/sinhnhat11nam/img_main/icon-longvu.png',
            imgDuaPhep: '/images/sinhnhat11nam/img_main/dua-phep.png',
            iconDamattrang: '/images/sinhnhat11nam/img_main/icon-da-mat-trang.png',
            randomMessages: [
                "Hãy mở tiếp cho đến khi tổ tiên mách bảo!",
                "Hãy nhận tạm ít bụi tiên để tích lũy thêm may mắn nhé~",
                "Bạn nhận được 1 lời khen 'Chiến binh đáng yêu nhất GOSU!'",
                "Câu thần chú có vẻ chưa đúng nên chưa có trúng.",
                "Bạn không sai, Share To Shine!",
                "Vừa trượt tay có tí, làm lại lần nữa nào!"
            ],
            imgthuvien: '/images/sinhnhat11nam/img_main/img-thuvien.png',
        };
    },
    created() {
        this.getFlip();
        // this.getItemUser();
    },
    methods: {
        ...authMethods,
        ...authGetters,
        // getItemUser() {
        //     let self = this;
        //     axios.get('/api/get-item', {
        //     })
        //         .then(function (response) {
        //             if (response.data.status === 200 && response.data.success == true) {
        //                 // self.diamond = response.data.data.diamond;
        //                 // self.attrKimcuong = response.data.data.diamond;
        //                 self.feathers = response.data.data.feathers;
        //                 console.log("response.data.data", response.data.data);

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

        backgroundImageUrl(type) {
            if (type == 1) {
                return this.itemPuple;
            }
            if (type == 2) {
                return this.itemRed;
            }
            if (type == 3) {
                return this.itemGreen;
            }
            if (type == 4) {
                return this.itemPink;
            }
            if (type == 5) {
                return this.itemYellow;
            }
        },

        async getFlip() {
            let self = this;
            axios.get('/api/get-flip-tvtt', {
            })
                .then(function (response) {
                    if (response.data.status === 200 && response.data.success == true) {
                        self.flipList = response.data.data.data_flip;

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
        async flipCard(index) {

            if (this.flipList[index].active == 0 && this.flipList[index].type == 0) {

                const formData = new FormData();
                formData.append("id", index);
                let self = this;
                // let flipList = this.flipList;
                this.flag = true;

                axios.post('/api/active-flip-tvtt-2', formData, {
                })
                    .then(function (response) {
                        if (response.data.status === 200) {
                            if (response.data.success == true) {
                                self.flipList[index] = { active: true, color: response.data.data.data_flip[index].color };

                                // self.flipList = flipList;
                                // self.flipList = response.data.data.data_flip.active_flip;
                                if (response.data.data.user) {
                                    // const userResponseJSON = JSON.stringify(response.data.data.user);
                                    // self.saveInfoUser(userResponseJSON);

                                    // self.diamond = response.data.data.user.diamond

                                    // self.attrKimcuong = response.data.user.diamond;
                                    // self.feathers = response.data.data.user.feathers
                                    self.$emit("updateAttrKimcuongNtd", response.data.data.user.diamond);
                                    self.$emit("updateAttrLongvuNtd", response.data.data.user.feathers);
                                    // this.$store.actions.saveInfoUser(response.data.data.user);
                                }
                                // if (response.data.data.data_flip.choises && response.data.data.data_flip.choises.length == 0) {
                                setTimeout(() => {
                                    if (response.data.data.reward) {
                                        let reward = response.data.data.reward;
                                        let imageUrl = "";
                                        let message = "";
                                        let customClass = "";
                                        if (reward.length == 0) {
                                            message = "Chúc bạn may mắn lần sau.";
                                            const randomIndex = Math.floor(Math.random() * self.randomMessages.length);
                                            message = self.randomMessages[randomIndex];
                                            imageUrl = '/images/sinhnhat11nam/img_main/may-man-lan-sau.png'
                                            customClass = 'swal-wide error';
                                        } else {
                                            customClass = 'swal-wide';
                                            for (let i = 0; i < reward.length; i++) {
                                                console.log("reward[i]", reward[i].record);
                                                console.log("reward[i].item_id: ", reward[i].item_id);

                                                if (reward[i].item_id == "1") {
                                                    console.log("message: ", message);
                                                    console.log("reward[i].record: ", reward[i].record);
                                                    message = message + reward[i].record + " Lông Phượng Hoàng";
                                                    console.log("message: ", message);
                                                    imageUrl = self.iconLongvu;
                                                }
                                                if (reward[i].item_id == "2") {
                                                    message = message + reward[i].record + " Đá mặt trăng";
                                                    imageUrl = self.iconDamattrang;
                                                }
                                                if (reward[i].item_id == "3") {
                                                    message = message + reward[i].record + " Thẻ Tiềm Long";
                                                    imageUrl = '/images/sinhnhat11nam/img_main/img_quatiemlong.png'
                                                }
                                            }
                                        }

                                        // alert(message);
                                        self.$swal.fire({
                                            position: "center",
                                            // icon: "success",
                                            text: message,
                                            title:"Bạn đã nhận được",
                                            showConfirmButton: false,
                                            timer: 1500,
                                            customClass: customClass,
                                            imageUrl: imageUrl,
                                            imageHeight: 80,
                                        });
                                    }
                                    self.flag = false;
                                }, 500); // 500 milliseconds = 0.5 giây
                            } else {
                                console.log("check response.data.message", response.data.message);
                                if (response.data.data.data_flip) {
                                    // self.flipList = response.data.data.data_flip;
                                }
                                self.$swal.fire({
                                    position: "center",
                                    icon: "error",
                                    title: response.data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }


                            // } else {
                            //     self.flag = false;
                            // }
                        } else {
                            self.flag = false;
                        }
                    })
                    .catch((error) => {
                        this.flag = true;
                        console.log(error);
                        if (error.response && error.response.status === 401) {
                            this.logoutSubmit()
                        }
                    })
                    .finally();
            }
        },


        reloadFlip() {
            let self = this;
            axios.get('/api/reload-flip-tvtt', {
            })
                .then(function (response) {
                    if (response.data.status === 200 && response.data.success == true) {
                        self.flipList = response.data.data.data_flip;
                        // if (response.data.data.user) {

                        //     self.$emit("updateAttrKimcuongNtd", response.data.data.user.diamond);
                        //     self.$emit("updateAttrLongvuNtd", response.data.data.user.feathers);
                        // }
                    } else {
                        // alert(response.data.message);
                        self.$swal.fire({
                            position: "center",
                            icon: "error",
                            title: response.data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
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
        async logoutSubmit() {
            console.log("signOut");
            await this.logout();
        },

        cursorDua() {
            const cursorDua = document.getElementById('img-dua'),
                mainLDFirst = document.getElementsByClassName("game-thuvientoantri"),

                withClassHover = document.getElementsByClassName("cursor-hover"),
                cPointer = document.getElementsByClassName("c-pointer"),

                withInMainKimCuong = [
                ...mainLDFirst,
                // ...mainKimCuong, 
                // ...bgKimCuong, 
                // ...imgBgKimCuong, 
                // ...listKimCuong, 
                // ...itKimCuong,
                // ...imgAni,
            ];
            
            document.addEventListener("mousemove", onMouseMove);
            document.addEventListener("mousedown", PressBua);
            document.addEventListener("mouseup", exitPressBua);

            withInMainKimCuong.forEach((element) => {
            element.addEventListener("mouseover", showBua);
            element.addEventListener("mouseout", hideBua);

            
            })

            function showBua() {
                cursorDua.style.opacity = 1;
            }
            function hideBua() {
                cursorDua.style.opacity = 0;
            }
            function PressBua() {
                cursorDua.style.transform  = "rotate(-30deg)";
            }
            function exitPressBua() {
                cursorDua.style.transform  = "rotate(0deg)";
            }

            function onMouseMove(e) {
                cursorDua.style.left = e.clientX-(40)+'px'
                cursorDua.style.top = e.clientY-(20)+'px'
            }
        },
    },
    // code test keyboard
    watch: {
    },
    computed: {
        UserInfo() {
            let user = JSON.parse(this.$store.getters.infoUser);
            return {
                id: user ? user.id : 0,
                diamond: user ? user.diamond : 0,
                feathers: user ? user.feathers : 0,
            }
        }
    },
    mounted() {
        this.cursorDua();
    },
};
</script>

<style>

.game-thuvientoantri{
    cursor: none;
}

.game-thuvientoantri .card {
    perspective: 1000px;
    position: relative;
    transform-style: preserve-3d;
    transition: transform 0.5s linear;
    display: inline-block;
    /* border: 1px solid transparent; */
    /* border-radius: 5px; */
    min-width: 65px;
    width: 100%;
    height: 65px !important;
    /* background:
        linear-gradient(to bottom, #292929, #453d69) padding-box,
        linear-gradient(to bottom, #7b5d1c, #a1813f) border-box; */
    background: url('../../../assets/images/sinhnhat11nam/img_main/front.png');
}

.game-thuvientoantri .card.flipped{
    border: 1px solid transparent;
    border-radius: 5px;
    background:
            linear-gradient(to bottom, #292929, #453d69) padding-box,
            linear-gradient(to bottom, #7b5d1c, #a1813f) border-box !important;
}

.game-thuvientoantri .card:hover {
    filter: brightness(140%);
}

.game-thuvientoantri .cell,
.game-thuvientoantri .item-wait {
    margin-right: 20px;
    margin-bottom: 30px;
    max-width: 65px;
    max-height: 65px;
}

.game-thuvientoantri .cell:nth-child(15n + 0) {
    margin-right: 0px;
}

.game-thuvientoantri .minigame-thuvien {
    min-height: 285px;
    transition: all 500ms linear
}

.game-thuvientoantri .card {
    background-repeat: no-repeat !important;
    background-position: center center !important;
    background-size: cover !important;
}

/* .game-thuvientoantri .row>*{
    width: auto;
} */

.minigame-thuvien .image img,
.card-wait {
    transition: all 1s linear
}

.flipped {
    transform: rotateY(180deg);
}

.cell-wait {
    min-height: 145px;
    padding-left: 50px;
}

.front,
.back {
    position: absolute;
    width: 100%;
    height: 100%;
    backface-visibility: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 300ms linear;
    border-radius: 5px;
}

.front {
    transform: rotateY(0deg);
    /* background-color: #f5f5f5; */
}

.back {
    transform: rotateY(180deg);
    background-color: #3498db;
    /* color: white; */
    /* border: solid #000; */
    border-radius: 5px;
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

.btn-start {
    position: absolute;
    z-index: 5;
    top: 170px;
    left: 105px;
    color: #292929;
    background: linear-gradient(to bottom, #f1c461, #a1813f);
    border-radius: 5px;
    border: none;
    padding: 10px 20px;
    font-weight: bold;
    transition: all 300ms linear;
}


.attribute-items .div-img {
    position: relative;
}

.attribute-items .div-img.items span {
    position: absolute;
    bottom: 26px;
    right: 50%;
    text-align: center;
    transform: translate(50%, 0%);
}

.attribute-items .div-img.items.longvu span {
    bottom: 30px;
    transform: translate(60%, 0%);
}

.attribute-items .div-img img:hover,
.btn-start:hover {
    filter: brightness(140%);
}



/* ... CSS sau đó ... */
</style>