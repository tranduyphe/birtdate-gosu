<template>
    <div id="ThapThanhTuu-Modal">

        <!-- Nội dung modal ở đây -->
        <div class="tab-thanhtuu">
            <div class="nav flex-column nav-tabs border-0" id="v-tabs-tab" role="tablist" aria-orientation="vertical">
                <div class="nav-item mb-3">
                    <a class="nav-link active" id="v-tabs-thu-thach-tab" data-bs-toggle="tab" href="#v-tabs-thu-thach"
                        role="tab" aria-controls="v-tabs-thu-thach" aria-selected="true">Bảng<br>thử thách</a>
                </div>

                <div class="nav-item mb-3">
                    <a class="nav-link" id="v-tabs-ky-tich-tab" data-bs-toggle="tab" href="#v-tabs-ky-tich" role="tab"
                        aria-controls="v-tabs-ky-tich" aria-selected="false">Chậu<br>kỳ tích</a>
                </div>

                <div class="nav-item mb-3">
                    <a class="nav-link" id="v-tabs-lich-tab" data-bs-toggle="tab" href="#v-tabs-lich" role="tab"
                        aria-controls="v-tabs-lich" aria-selected="false">Lịch<br>tưởng ký</a>
                </div>

                <div class="nav-item mb-3">
                    <a class="nav-link" id="v-tabs-the-le-tab" data-bs-toggle="tab" href="#v-tabs-the-le" role="tab"
                        aria-controls="v-tabs-the-le" aria-selected="false">Thể lệ</a>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-12 pr-0">
                <div class="tab-content" id="v-tabs-tabContent">
                    <div class="tab-pane fade show active" id="v-tabs-thu-thach" role="tabpanel"
                        aria-labelledby="v-tabs-thu-thach-tab">
                        <div class="title text-center">
                            <h2 class="title-modal">Bảng thử thách</h2>
                            <img :src="lineBreak" class="mb-3">
                        </div>

                        <div class="task row justify-content-evenly">
                            <div v-for="(item, index) in quests" :key="index"
                                class="item-task col-lg-5 d-flex align-items-center justify-content-between">
                                <span class="star"
                                    :style="{ color: item.is_reward == 0 ? '#b2ad8a' : '#289e11' }">&#10022;</span>
                                <div class="item-info col-8 d-flex align-items-center">
                                    <p class="m-0">{{ item.name }}</p>
                                    <div class="friendcode d-flex" v-if="index == 1"><input class="form-control w-75" v-model="friendCode"><button class="btn btn-success" type="button" @click="invite">Mời</button></div>
                                </div>
                                <div class="point">
                                    <p class="m-0" :style="{ color: item.is_reward == 0 ? '#b2ad8a' : '#289e11' }">{{
                                        item.current_attempts }}/{{ item.total_attempts }}</p>
                                </div>
                                
                                <div class="item-button" v-if="item.is_reward == 0">
                                    <button class="btn p-0" @click="getReWard(item.type)"><img :src="iconBtn"
                                            title="Bấm vào đây để nhận thưởng"></button>
                                    <span class="diamond-reward">{{ item.diamond_reward }}</span>
                                </div>
                                <div v-else>
                                    <img :src="iconBtn" :style="{ opacity: 0.7 }" alt="" title="Đã nhận thưởng">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-tabs-ky-tich" role="tabpanel" aria-labelledby="v-tabs-ky-tich-tab">
                        <div class="title text-center">
                            <h2 class="title-modal">Chậu kỳ tích</h2>
                            <img :src="lineBreak" class="mb-3">
                        </div>
                        <div class="task row justify-content-evenly">
                            <div class="thanhtich col-7">
                                <div v-for="(item, index) in topFeathers" :key="index" class="item-task p-3">
                                    <div class="item-info d-flex align-items-center justify-content-between">
                                        <div class="rank col-1">
                                            <img v-if="index + 1 == 1" :src="img_rank1" alt="" width="60">
                                            <img v-else-if="index + 1 == 2" :src="img_rank2" alt="" width="60">
                                            <img v-else-if="index + 1 == 3" :src="img_rank3" alt="" width="60">
                                            <p class="m-0" v-else>{{ index + 1 }}</p>
                                        </div>
                                        <div class="avatar">
                                            <img :src="iconBtn" width="60" height="60">
                                        </div>
                                        <div class="col-5">
                                            <p class="m-0">{{ item.name }}</p>
                                        </div>
                                        <div class="attr-longvu col-2">
                                            <p class="m-0">{{ item.feathers }}</p>
                                            <img :src="iconLongvu" alt="" title="Lông Vũ" width="40">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade lich-tuong-ky" id="v-tabs-lich" role="tabpanel"
                        aria-labelledby="v-tabs-lich-tab">
                        <div class="title text-center">
                            <h2 class="title-modal">Lịch tưởng ký</h2>
                            <img :src="lineBreak" class="mb-3">
                        </div>

                        <div class="task row justify-content-evenly">
                            <div v-for="(item, index) in logActivity" :key="index"
                                class="item-task col-12 row justify-content-between text-center">
                                <div class="item-created-at col-2">
                                    <p class="m-0">{{ item.formatted_created_at }} </p>
                                </div>
                                <div class="item-reason col-8">
                                    <p class="m-0">{{ item.reason }}</p>
                                </div>
                                <div class="item-reason col-1">
                                    <p class="m-0">123</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-tabs-the-le" role="tabpanel" aria-labelledby="v-tabs-the-le-tab">
                        <div class="title text-center">
                            <h2 class="title-modal">Thể lệ</h2>
                            <img :src="lineBreak" class="mb-3">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {
    authGetters,
    authMethods,
} from "@/store/store";
export default {
    data() {
        return {
            quests: [],
            topFeathers: [],
            logActivity: [],
            lineBreak: '/images/sinhnhat11nam/img_main/linebreak-title.png',
            iconBtn: '/images/sinhnhat11nam/img_main/icon-button-task.png',
            iconLongvu: '/images/sinhnhat11nam/img_main/icon-longvu.png',
            img_chauthanhtich: '/images/sinhnhat11nam/img_main/img_chauthanhtich.png',
            img_rank1: '/images/sinhnhat11nam/img_main/rank1.png',
            img_rank2: '/images/sinhnhat11nam/img_main/rank2.png',
            img_rank3: '/images/sinhnhat11nam/img_main/rank3.png',
            friendCode: "",
            rewardFlag: false,
            inviteFlag: false,
        };
    },
    created() {
        this.getQuest();
        this.getTopFeathers();
        this.getLogActivity();
    },
    methods: {
        ...authMethods,
        ...authGetters,

        async invite() {
            if (this.quests[1] && this.quests[1]['current_attempts'] < this.quests[1]['total_attempts']) {
                if (this.inviteFlag == false) {
                    this.inviteFlag = true;
                    let user = await this.users();
                    let self = this;
                    axios.get('/api/invite', {
                        params: {
                            user_code: this.friendCode,
                            user_name: user.name
                        },
                    })
                        .then(function (response) {
                            self.inviteFlag = false;
                            if (response.data.status === 200 && response.data.success == true) {
                                self.quests = response.data.data.quests;
                                if(response.data.message == 'Không tìm thấy Bạn học này'){
                                    self.$swal.fire({
                                        position: "center",
                                        icon: "error",
                                        title: response.data.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                }else{
                                    self.$swal.fire({
                                        position: "center",
                                        icon: "success",
                                        title: response.data.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                }
                               
                            }
                        })
                        .catch((error) => {
                            self.inviteFlag = false;
                            if (error.response && error.response.status === 401) {
                                this.logoutSubmit()
                            }
                            console.log(error);
                        })
                        .finally();
                }


            }
        },
        getQuest() {
            let self = this;
            axios.get('/api/get-quests', {
            })
                .then(function (response) {
                    if (response.data.status === 200 && response.data.success == true) {
                        self.quests = response.data.data.quests;
                        console.log("check quest list:", self.quests);
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
        getLogActivity() {
            let self = this;
            axios.get('/api/get-log-activity', {

            })
                .then(function (response) {
                    if (response.data.status === 200 && response.data.success == true) {
                        self.logActivity = response.data.data.log_activity;
                        console.log("checklog activity:", self.logActivity);
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
        async getReWard(questId) {
            console.log("check get reward");
            if (this.rewardFlag == false) {
                this.rewardFlag = true;
                let user = await this.users();
                let self = this;
                axios.get('/api/get-reward', {
                    params: {
                        quest_id: questId,
                        user_name: user.name
                    },
                })
                    .then(function (response) {
                        self.rewardFlag = false;
                        if (response.data.status === 200) {
                            if (response.data.success == true) {
                                self.quests = response.data.data.quests;
                                // alert(response.data.message);
                                self.$swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: response.data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                console.log("check quest list:", self.quests);
                            } else {
                                if (response.data.data.quests) {
                                    self.quests = response.data.data.quests;
                                }
                                // alert(response.data.message);
                                self.$swal.fire({
                                    position: "center",
                                    icon: "error",
                                    title: response.data.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        }
                    })
                    .catch((error) => {
                        self.rewardFlag = false;
                        console.log(error);
                        if (error.response && error.response.status === 401) {
                            this.logoutSubmit()
                        }
                    })
                    .finally();
            }

        },
        getTopFeathers() {
            let self = this;
            axios.get('/api/get-top-feathers', {

            })
                .then(function (response) {
                    if (response.data.status === 200 && response.data.success == true) {
                        self.topFeathers = response.data.data.top_feathers;
                        console.log("check quest top_feathers:", self.topFeathers);
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
    },
};
</script>

<style>
.tab-thanhtuu {
    position: absolute;
    top: 195px;
    left: -148px;
}

.tab-thanhtuu .nav-link {
    /* background: cyan; */
    transition: all 0.3s linear;
    /* Sử dụng transition cho width và left */
    width: 185px;
    height: 81px;
    background: url('../../../../../assets/images/sinhnhat11nam/img_main/tab-nonactive.png');
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
}

.tab-thanhtuu .nav-link.active {
    background-color: transparent;
    background: url('../../../../../assets/images/sinhnhat11nam/img_main/tab-active.png');
    margin-left: -40px;
    width: 225px;
}

.tab-thanhtuu .nav-item a {
    font-size: 18px;
    color: #292c48;
    text-transform: uppercase;
}

.tab-thanhtuu .nav-item a.active {
    color: #8e6245;
}

#ThapThanhTuu-Modal .tab-pane .task {
    max-height: 415px;
    overflow-y: auto;
}

@keyframes expandWidth {
    0% {
        width: 100px;
    }

    100% {
        width: 200px;
    }
}

.title-modal {
    font-family: "UTMGodsWordBold";
    text-transform: uppercase;
    color: #4d4b39;
    text-align: center;
}

#ThapThanhTuu-Modal .tab-pane .task .item-task {
    padding-right: 0;

}

#ThapThanhTuu-Modal .tab-pane .task::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    background-color: #F5F5F5;
    border-radius: 10px;
}

#ThapThanhTuu-Modal .tab-pane .task::-webkit-scrollbar {
    width: 10px;
    background-color: transparent;
}

#ThapThanhTuu-Modal .tab-pane .task::-webkit-scrollbar-thumb {
    border-radius: 10px;
    background-image: -webkit-gradient(linear,
            left bottom,
            left top,
            color-stop(0.44, rgb(217, 203, 122)),
            color-stop(0.72, rgb(189, 168, 73)),
            color-stop(0.86, rgba(158, 124, 14, 0.836)));
}

.item-task .star {
    font-size: 36px;
    margin-left: -27px;
}

.item-task {
    background: #edebdc;
    margin-bottom: 20px;
}

.item-button {
    transition: all 0.3s linear;
    position: relative;
    cursor: pointer;
}

.item-button button {
    border: none;
}

.item-button span.diamond-reward {
    position: absolute;
    right: 2px;
    bottom: 0;
    color: #F5F5F5;
    font-family: 'Tahoma';
}

.item-button:hover {
    filter: brightness(150%);
}

.item-info {
    font-family: 'Tahoma';
}

.thanhtich .item-task {
    border-radius: 5px;
}

.thanhtich .avatar img {
    border-radius: 50%;
}

.attr-longvu p {
    display: inline-block;
}

.lich-tuong-ky .item-task {
    background: none;
}

.lich-tuong-ky .item-reason,
.item-task .item-created-at {
    background: #edebdc;
}

.friendcode {
    max-height: 45px;
}

.friendcode input{
    border-bottom-right-radius: 0;
    border-top-right-radius: 0;
}

.friendcode button{
    border-bottom-left-radius: 0;
    border-top-left-radius: 0;
}
</style>