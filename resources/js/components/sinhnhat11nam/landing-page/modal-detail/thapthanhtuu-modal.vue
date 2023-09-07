<template>
    <div id="ThapThanhTuu-Modal">
      <!-- Nội dung modal ở đây -->
        <div class="tab-thanhtuu">
            <div
            class="nav flex-column nav-tabs text-center"
            id="v-tabs-tab"
            role="tablist"
            aria-orientation="vertical"
            >
                <div class="nav-item mb-3">
                    <a
                    class="nav-link active"
                    id="v-tabs-home-tab"
                    data-bs-toggle="tab"
                    href="#v-tabs-home"
                    role="tab"
                    aria-controls="v-tabs-home"
                    aria-selected="true"
                    >Bảng thử thách</a>
                </div>
                
                <div class="nav-item mb-3">
                    <a
                    class="nav-link"
                    id="v-tabs-profile-tab"
                    data-bs-toggle="tab"
                    href="#v-tabs-profile"
                    role="tab"
                    aria-controls="v-tabs-profile"
                    aria-selected="false"
                    >Lịch tưởng ký</a>
                </div>
                
                <div class="nav-item mb-3">
                    <a
                    class="nav-link"
                    id="v-tabs-messages-tab"
                    data-bs-toggle="tab"
                    href="#v-tabs-messages"
                    role="tab"
                    aria-controls="v-tabs-messages"
                    aria-selected="false"
                    >Chậu kỳ tích</a>
                </div>
                
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="tab-content" id="v-tabs-tabContent">
                <div
                    class="tab-pane fade show active"
                    id="v-tabs-home"
                    role="tabpanel"
                    aria-labelledby="v-tabs-home-tab"
                >
                    <ul>
                        <li v-for="(item, index) in quests" :key="index" class="quest-item">
                            <div class="quest-info">
                                <p>{{ item.name }} {{ item.current_attempts }}/{{ item.total_attempts }}</p>
                            </div>
                            <div class="quest-button">
                                <button v-if="item.is_reward == 0" @click="getReWard(item.type)">nhận thưởng</button>
                                <button v-else>đã nhận thưởng</button>
                            </div>
                        </li>
                    </ul>
                </div>
                <div
                    class="tab-pane fade"
                    id="v-tabs-profile"
                    role="tabpanel"
                    aria-labelledby="v-tabs-profile-tab"
                >
                    <ul>
                        <li v-for="(item, index) in topFeathers" :key="index" class="quest-item">
                            <div class="quest-info">
                                <p>{{ item.name }} - {{ item.feathers }}</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div
                    class="tab-pane fade"
                    id="v-tabs-messages"
                    role="tabpanel"
                    aria-labelledby="v-tabs-messages-tab"
                >
                    <ul>
                        <li v-for="(item, index) in logActivity" :key="index" class="quest-item">
                            <div class="quest-info">
                                <p>{{ item.formatted_created_at }}: {{ item.reason }} </p>
                            </div>
                        </li>
                    </ul>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            quests: [],
            topFeathers: [],
            logActivity: [],
        };
    },
    created() {
        this.getQuest();
        this.getTopFeathers();
        this.getLogActivity();
    },
    methods: {
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
                })
                .finally();
        },
        getReWard(questId) {
            let self = this;
            axios.get('/api/get-reward', {
                params: {
                    quest_id: questId
                },
            })
                .then(function (response) {
                    if (response.data.status === 200) {
                        if (response.data.success == true) {
                            self.quests = response.data.data.quests;
                            alert(response.data.message);
                            console.log("check quest list:", self.quests);
                        } else {
                            self.quests = response.data.data.quests;
                            alert(response.data.message);
                            console.log("check quest list:", self.quests);
                        }
                    }
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally();
        },
        getTopFeathers() {
            let gameId = this.$store.getters.gameId;
            // let gameId = 0;
            console.log("check gameID: ", this.$store.getters.gameId)
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
                })
                .finally();
        },
    },
};
</script>

<style>
.tab-thanhtuu{
    position: absolute;
    top: 195px;
    left: -165px;
}

.nav-item{
    background: cyan;
    transition: all 3s linear;
    min-width: 200px;
}

.nav-link{
    transition: all 0.3s linear; /* Sử dụng transition cho width và left */
}

.nav-link.active {
    margin-left: -50px;
}

.tab-pane{
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
</style>