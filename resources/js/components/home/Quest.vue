<template>
    <p>test page quest</p>
    <div>
        <button @click="showMedalPopup" class="btn btn-primary">Bảng thử thách</button>
        <!-- Modal -->
        <div class="modal fade" id="medalModal" tabindex="-1" role="dialog" aria-labelledby="medalModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="medalModalLabel">Bảng thử thách</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            @click="closeMedalPopup">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            @click="closeMedalPopup">Đóng</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chậu kỳ tích -->
        <button @click="showMedalPopupCKT" class="btn btn-primary">Chậu Kỳ Tích</button>
        <!-- Modal -->
        <div class="modal fade" id="medalModalCKT" tabindex="-1" role="dialog" aria-labelledby="medalModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="medalModalLabel">Chậu Kỳ Tích</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            @click="closeMedalPopupCKT">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul>
                            <li v-for="(item, index) in topFeathers" :key="index" class="quest-item">
                                <div class="quest-info">
                                    <p>{{ item.name }} - {{ item.feathers }}</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            @click="closeMedalPopupCKT">Đóng</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lịch Tưởng Ký -->
        <button @click="showMedalPopupLTK" class="btn btn-primary">Lịch Tưởng Ký</button>
        <!-- Modal -->
        <div class="modal fade" id="medalModalLTK" tabindex="-1" role="dialog" aria-labelledby="medalModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="medalModalLabel">Lịch Tưởng Ký</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            @click="closeMedalPopupLTK">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul>
                            <li v-for="(item, index) in logActivity" :key="index" class="quest-item">
                                <div class="quest-info">
                                    <p>{{ item.formatted_created_at }}: {{ item.reason }} </p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            @click="closeMedalPopupLTK">Đóng</button>
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
        showMedalPopup() {
            $('#medalModal').modal('show');
        },
        closeMedalPopup() {
            $('#medalModal').modal('hide');
        },

        showMedalPopupCKT() {
            $('#medalModalCKT').modal('show');
        },
        closeMedalPopupCKT() {
            $('#medalModalCKT').modal('hide');
        },

        showMedalPopupLTK() {
            $('#medalModalLTK').modal('show');
        },
        closeMedalPopupLTK() {
            $('#medalModalLTK').modal('hide');
        },

        getQuest() {
            let self = this;
            axios.get('/api/get-quests', {
            })
                .then(function (response) {
                    if (response.data.status === 200 && response.data.success == true) {
                        self.quests = response.data.data.quests;
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
                        } else {
                            self.quests = response.data.data.quests;
                            alert(response.data.message);
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
        },
        getTopFeathers() {
            let self = this;
            axios.get('/api/get-top-feathers', {

            })
                .then(function (response) {
                    if (response.data.status === 200 && response.data.success == true) {
                        self.topFeathers = response.data.data.top_feathers;
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
.quest-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
    /* Tùy chỉnh margin nếu cần */
}

.quest-info {
    flex-grow: 1;
    /* Thẻ p tự mở rộng để điền vào khoảng trống */
}

.quest-button {
    margin-left: 10px;
    /* Tùy chỉnh margin nếu cần */
}
</style>
    
  
  