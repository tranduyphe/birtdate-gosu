<template>
    <h3 class="text-center mt-5">Game mini</h3>
    <div>Lông phượng hoàng:{{ feathers }}</div>
    <div>Đá mặt trăng: {{ diamond }}</div>
    <h1 class="text-center mt-5" v-if="checkGameOver">Game Over</h1>
    <button @click="reloadFlip()">
        Start
    </button>
    <div class="container" v-if="flipList != nul">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered" style="background-color: gray;">
                    <thead>
                        <!-- <tr>
                            <th>Column 1</th>
                            <th>Column 2</th>
                            <th>Column 3</th>
                            <th>Column 4</th>
                            <th>Column 5</th>
                            <th>Column 6</th>
                        </tr> -->
                    </thead>
                    <tbody>
                        <tr v-for="row in 5" :key="row">
                            <td v-for="col in 9" :key="col">
                                <div v-if="flipList[(row - 1) * 9 + col - 1]" class="card"
                                    :class="{ flipped: flipList[(row - 1) * 9 + col - 1].active > 0 }"
                                    @click="flipCard((row - 1) * 9 + col - 1)"
                                    :style="{ backgroundColor: flipList[(row - 1) * 9 + col - 1].color }">
                                    <div class="front">
                                    </div>
                                    <div v-if="flipList[(row - 1) * 9 + col - 1].active == 1" 
                                        :style="{ backgroundColor: flipList[(row - 1) * 9 + col - 1].color }">
                                    </div>
                                    <div v-else-if="flipList[(row - 1) * 9 + col - 1].active == 2" class="back"
                                        :style="{ backgroundColor: 'black' }">
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-12">
                <table class="table table-bordered" style="background-color: gray;">
                    <thead>
                        <tr>
                            <th v-for="col in 6">
                                <div class="card" :class="{ flipped: waiting[col - 1] && waiting[col - 1] > 0 }">
                                    <div class="front">
                                    </div>
                                    <div class="back" :style="{ backgroundColor: cardBackgroundColor(col - 1) }">
                                    </div>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</template>
  
<script>
import {
    authGetters,
    authMethods,
} from "@/store/store";
// Tạo kết nối Socket.io
// import io from "socket.io-client";
export default {
    props: {},
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
            diamond :0,
            feathers:0,
            gameId:0,

        };
    },
    created() {
        this.getFlip();
        this.getItemUser();
        // this.gameId();
    },
    methods: {
        ...authMethods,
        ...authGetters,
        getItemUser() {
            let self = this;
            axios.get('/api/get-item', {
            })
                .then(function (response) {
                    if (response.data.status === 200 && response.data.success == true) {
                        self.diamond = response.data.data.diamond;
                        self.feathers = response.data.data.feathers;
                        console.log("response.data.data",response.data.data);
                    }
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally();
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
                        console.log("response.data.data",response.data.data);

                    }
                })
                .catch((error) => {
                    console.log(error);
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
                                    
                                    self.diamond = response.data.data.user.diamond
                                    self.feathers = response.data.data.user.feathers
                                    // this.$store.actions.saveInfoUser(response.data.data.user);
                                }
                                // if (response.data.data.data_flip.choises && response.data.data.data_flip.choises.length == 0) {
                                    setTimeout(() => {
                                        self.flipList = response.data.data.data_flip.active_flip;
                                        self.waiting = response.data.data.data_flip.waiting;
                                        self.flag = false;
                                    }, 500); // 500 milliseconds = 0.5 giây
                                // } else {
                                //     self.flag = false;
                                // }
                            }else{
                                self.flag = false;
                            }
                        })
                        .catch((error) => {
                            console.log(error);
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
                            self.diamond = response.data.data.user.diamond
                            self.feathers = response.data.data.user.feathers
                            // self.saveInfoUser(userResponseJSON);
                            // this.$store.actions.saveInfoUser(response.data.data.user);
                        }
                        if (response.data.data.game_id) {
                            const gameId = response.data.data.game_id;
                            self.saveGameId(gameId);
                            // this.$store.actions.saveInfoUser(response.data.data.user);
                        }
                    } else {
                        alert(response.data.message);
                    }
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally();
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
        },
        checkGameOver() {
            return this.waiting.length >= 6;
        },
        cardBackgroundColor() {
            return (col) => {
                if (this.waiting[col] === 1) {
                    return 'blue';
                } else if (this.waiting[col] === 2) {
                    return 'red';
                } else if (this.waiting[col] === 3) {
                    return 'green';
                } else if (this.waiting[col] === 4) {
                    return 'pink';

                } else if (this.waiting[col] === 5) {
                    return 'orange';

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
    width: 40px;
    height: 40px;
    perspective: 1000px;
    position: relative;
    transform-style: preserve-3d;
    transition: transform 0.5s;
}

.flipped {
    transform: rotateY(180deg);
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

}

.front {
    transform: rotateY(0deg);
    /* background-color: #f5f5f5; */


}

.back {
    transform: rotateY(180deg);
    background-color: #3498db;
    color: white;
    border: solid #000;
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