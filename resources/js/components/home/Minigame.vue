<template>
    <div class="game-thuvientoantri">
        <div class="btn-start-div">
            <button @click="reloadFlip()">Làm mới</button>
            <span>Nhấp "Làm mới" để bắt đầu. Mỗi lượt tốn 2 Đá Mặt Trăng để lật 3 ô ngẫu nhiên. Tìm kiếm bóng lửa cùng loại để mở hết bảng và nhận 2 Lông Phượng Hoàng.</span>
        </div>
        
        <p class="text-center text-white" v-if="checkGameOver">Bạn đã thua cuộc, vui lòng "Làm mới" để tiếp tục (Trừ 5 đá mặt trăng)</p>
        <div class="row justify-content-center align-items-center">
            <div class="minigame-thuvien">
                <div class="" v-if="flipList != nul">
                    <div v-for="row in 3" :key="row" class="row justify-content-center align-items-center"
                        data-aos="fade-up">
                        <div v-for="col in 15" :key="col" class="cell p-0">
                            <div v-if="flipList[(row - 1) * 15 + col - 1]" class="card mb-0"
                                :class="{ flipped: flipList[(row - 1) * 15 + col - 1].active > 0, }"
                                @click="flipCard((row - 1) * 15 + col - 1)"
                                :style="{ opacity: flipList[(row - 1) * 15 + col - 1].active == 2 ? '0' : '1' }">
                                <div class="image">
                                    <img data-aos="fade-up"
                                        :src="flipList[(row - 1) * 15 + col - 1].color == null ? imgtransparent : flipList[(row - 1) * 15 + col - 1].color"
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
            <div class="cell-wait col-md-8 mt-2 pl-5">
                <p class="text-wait font-size-16">&#9830;&nbsp;Số ô chờ đã fill/số ô chờ tổng&nbsp;<span class="px-1">{{
                    waiting.length }}/4</span></p>
                <div class="row mt-4">
                    <div class="item-wait p-0 mr-5" v-for="col in 4">
                        <div class="card-wait mb-0" :class="{ flipped: waiting[col - 1] && waiting[col - 1] > 0 }">
                            <div class="image" v-if="waiting[col - 1] && waiting[col - 1] > 0">
                                <img :src="cardBackgroundColor(col - 1)" alt="" width="65" height="65">
                            </div>
                        </div>
                    </div>
                </div>
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
            <div class="modalGameOver" data-aos="zoom-in-up" id="GameOverModal">
                <img :src="imgloser" width="800">
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
        attrKimcuong:Number,
        attrLongvu:Number,
    },
    data() {
        return {
            socket: null,
            pageConnected: true,
            accessToken: "", // Khởi tạo access token rỗng
            colors: ['blue', 'red', 'green', 'pink'],
            // flipList: new Array(33).fill({ active: false, color: '' }), // Tạo mảng 9 phần tử với giá trị ban đầu là false
            flipList: [],
            waiting: [],
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
            let gameId = await this.getGameId();
            let self = this;
            axios.get('/api/get-flip', {
                params: {
                    game_id: gameId
                },
            })
                .then(function (response) {
                    if (response.data.status === 200 && response.data.success == true) {
                        self.flipList = response.data.data.data_flip.active_flip;
                        self.waiting = response.data.data.data_flip.waiting ?? [];

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
            if (!this.checkGameOver && !this.flag) {

                if (this.flipList[index].active == 0 && this.flipList[index].type == 0) {

                    let gameId = await this.getGameId();
                    const formData = new FormData();
                    formData.append("id", index);
                    formData.append("game_id", gameId);
                    let self = this;
                    let flipList = this.flipList;
                    this.flag = true;

                    axios.post('/api/active-flip', formData, {
                    })
                        .then(function (response) {
                            if (response.data.status === 200 && response.data.success == true) {

                                flipList[index] = { active: true, color: response.data.data.data_flip.active_flip[index].color };

                                self.flipList = flipList;
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
                                    self.flipList = response.data.data.data_flip.active_flip;
                                    self.waiting = response.data.data.data_flip.waiting;
                                    if (response.data.data.reward) {
                                        let reward = response.data.data.reward;
                                        let message = "";
                                        for (let i = 0; i < reward.length; i++) {

                                            if (reward[i].item_id == "1") {
                                                message = message + " Lông Phượng Hoàng +" + reward[i].record;
                                            }
                                            if (reward[i].item_id == "2") {
                                                message = message + " Đá mặt trăng +" + reward[i].record;
                                            }
                                        }
                                        // alert(message);
                                        self.$swal.fire({
                                            position: "center",
                                            icon: "success",
                                            title: message,
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                    }
                                    self.flag = false;
                                }, 500); // 500 milliseconds = 0.5 giây

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
            }
        },
        // reconnect() {
        //     if (this.socket.connected) {
        //         // Socket đã kết nối, gửi tín hiệu
        //         const userId = this.UserInfo.id; // Thay bằng thông tin thực tế
        //         this.pageConnected = true;
        //         const pageConnected = this.pageConnected;
        //         console.log("check userId:", userId);
        //         console.log("check pageConnected:", pageConnected);
        //         this.socket.emit('userConnected', { userId, pageConnected });
        //         this.getFlip();
        //     } else {
        //         this.$swal.fire({
        //             icon: "info",
        //             title: "Thông báo",
        //             text: "Kết nối socket thất bại",
        //             allowOutsideClick: false, // Chặn nhấp vào vùng ngoài popup để tắt
        //             confirmButtonText: "Kết nối lại", // Tùy chọn tên nút confirm
        //         }).then((result) => {
        //             if (result.isConfirmed) {
        //                 // Xử lý logic khi người dùng nhấn nút "Kết nối lại"
        //                 this.reconnect();
        //             }
        //         });
        //     }
        // },


        reloadFlip() {
            let self = this;
            axios.get('/api/reload-flip', {
            })
                .then(function (response) {
                    if (response.data.status === 200 && response.data.success == true) {
                        self.flipList = response.data.data.data_flip.active_flip;
                        self.waiting = response.data.data.data_flip.waiting;
                        if (response.data.data.user) {
                            // const userResponseJSON = JSON.stringify(response.data.data.user);
                            // self.saveDiamond(response.data.data.user.diamond);
                            
                            self.$emit("updateAttrKimcuongNtd", response.data.data.user.diamond);
                            self.$emit("updateAttrLongvuNtd", response.data.data.user.feathers);
                            // self.diamond = response.data.data.user.diamond
                            // self.feathers = response.data.data.user.feathers
                            // self.saveInfoUser(userResponseJSON);
                            // this.$store.actions.saveInfoUser(response.data.data.user);
                        }
                        if (response.data.data.game_id) {
                            const gameId = response.data.data.game_id;
                            self.saveGameId(gameId);
                            // this.$store.actions.saveInfoUser(response.data.data.user);
                        }
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
            await this.logout();
        },
    },
    // code test keyboard
    watch: {
        checkGameOver(newValue) {
            if (newValue) {
                // Hiển thị modal khi game over
                $('#GameOverModal').css('display','flex');
                setTimeout(() => {
                    $('#GameOverModal').hide();
                }, 5000);
            }
        },
    },
    computed: {
        UserInfo() {
            let user = JSON.parse(this.$store.getters.infoUser);
            return {
                id: user ? user.id : 0,
                diamond: user ? user.diamond : 0,
                feathers: user ? user.feathers : 0,
            }
        },
        checkGameOver() {
            return this.waiting.length >= 4;
        },
        cardBackgroundColor() {
            return (col) => {
                if (this.waiting[col] === 1) {
                    return this.itemPuple;
                } else if (this.waiting[col] === 2) {
                    return this.itemRed;
                } else if (this.waiting[col] === 3) {
                    return this.itemGreen;
                } else if (this.waiting[col] === 4) {
                    return this.itemPink;

                } else if (this.waiting[col] === 5) {
                    return this.itemYellow;
                } else {
                    return '';
                }

            };
        }
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
    perspective: 1000px;
    position: relative;
    transform-style: preserve-3d;
    transition: transform 0.5s linear;
    display: inline-block;
    border: 1px solid transparent;
    border-radius: 5px;
    min-width: 65px;
    width: 100%;
    height: 65px !important;
    background:
        linear-gradient(to bottom, #292929, #453d69) padding-box,
        linear-gradient(to bottom, #7b5d1c, #a1813f) border-box;
}

.game-thuvientoantri .card:hover{
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

.btn-start-div {
    position: absolute;
    z-index: 5;
    top: 170px;
    left: 105px;
    font-weight: bold;
    transition: all 300ms linear;
    color: aliceblue;
}

.btn-start-div button{
    color: #292929;
    background: linear-gradient(to bottom, #f1c461, #a1813f);
    border-radius: 5px;
    border: none;
    padding: 10px 20px;
    font-weight: bold;
    margin-right: 8px;
}

.btn-start-div:hover {
    filter: brightness(140%);
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

#GameOverModal{
    display: none;
    background-color: rgba(0, 0, 0, 0.8);
    color: white;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    justify-content: center;
    align-items: center;
    font-size: 20px;
    text-align: center;
    transform-origin: center;
    /* transform: rotate(90deg) translateY(-50%); */
    white-space: nowrap;
    transition: transform 1s ease-in-out, opacity 1s ease-in-out;
    flex-direction: column;
}

/* ... CSS sau đó ... */
</style>