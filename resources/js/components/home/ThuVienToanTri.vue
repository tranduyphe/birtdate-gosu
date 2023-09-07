<template>
    <h3 class="text-center mt-5">Game mini</h3>
    <div>Lông phượng hoàng:{{ feathers }}</div>
    <div>Đá mặt trăng: {{ diamond }}</div>
    <h1 class="text-center mt-5" v-if="checkGameOver">Game Over</h1>
    <!-- <button @click="reloadFlip()">
        Start
    </button> -->
    <div class="container" v-if="flipList != nul">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered" style="background-color: gray;">
                    <thead>
                    </thead>
                    <tbody>
                        <tr v-for="row in 4" :key="row">
                            <td v-for="col in 8" :key="col">
                                <div class="card" @click="flipCard((row - 1) * 8 + col - 1)"
                                    :style="{ backgroundColor: flipList[(row - 1) * 8 + col - 1].color }">
                                    <div class="front">
                                    </div>
                                    <div v-if="flipList[(row - 1) * 8 + col - 1].active == 1"
                                        :style="{ backgroundColor: flipList[(row - 1) * 8 + col - 1].color }">
                                    </div>
                                    <div v-else-if="flipList[(row - 1) * 8 + col - 1].active == 2" class="back"
                                        :style="{ backgroundColor: 'black' }">
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
    props: {},
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
        };
    },
    created() {
        this.getFlip();
        this.getItemUser();
    },
    methods: {
        ...mapActions(["saveInfoUser", "saveGameId"]),
        getItemUser() {
            let self = this;
            axios.get('/api/get-item', {
            })
                .then(function (response) {
                    if (response.data.status === 200 && response.data.success == true) {
                        self.diamond = response.data.data.diamond;
                        self.feathers = response.data.data.feathers;
                        console.log("response.data.data", response.data.data);
                    }
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally();
        },
        getFlip() {
            this.flipList = [];
            for (let i = 0; i < 32; i++) {
                const randomColor = this.colors[Math.floor(Math.random() * this.colors.length)];
                this.flipList.push({ active: 1, color: randomColor });
            }
        },
        flipCard(index) {
            this.flag = true;
            if (this.diamond < 5) {
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
                                    self.diamond = response.data.data.user.diamond
                                    self.feathers = response.data.data.user.feathers
                                }
                                if (response.data.data.reward) {
                                    let reward = response.data.data.reward;
                                    let message = "";
                                    for (let i = 0; i < reward.length; i++) {
                                        console.log("reward[i]", reward[i].record);
                                        console.log("reward[i].item_id: ", reward[i].item_id);

                                        if (reward[i].item_id == "1") {
                                            console.log("message: ", message);
                                            console.log("reward[i].record: ", reward[i].record);
                                            message = message + " Lông phượng hoàng +" + reward[i].record;
                                            console.log("message: ", message);
                                        }
                                        if (reward[i].item_id == "2") {
                                            message = message + " Đá mặt trăng +" + reward[i].record;
                                        }
                                    }
                                    alert(message);
                                    self.getFlip();
                                    self.flag = false;
                                }
                            } else {
                                alert(response.data.message);
                                self.flag = false;
                            }
                        } else {
                            self.flag = false;
                        }
                    })
                    .catch((error) => {
                        self.flag = false;
                    })
                    .finally();
            }
        }
    },
    // code test keyboard
    watch: {

    },
    computed: {
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