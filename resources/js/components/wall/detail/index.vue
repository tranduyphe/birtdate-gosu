<script>
export default {
    props: {
        currentPadlet:{
            type: Object,
        }
    },
    components: {
        
    }, 
    data: () => {
        return{
        }
    },
    computed: {
    },
    methods: {
    },
    created: () => {
    },
    mounted: () => {  
    },
};
    
</script>
<template>
<button
        type="button"
        class="btn btn-primary showModal"
        data-bs-toggle="modal"
        data-bs-target="#padletModal"
        ref="padletModal"
    ></button>

    <!-- Modal -->
    <div
        class="modal fade"
        id="padletModal"
        tabindex="-1"
        aria-labelledby="padletModal"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div
                class="modal-content"
                v-bind:style="`background-color:rgb${currentPadlets.color && currentPadlets.color != 'null' ? currentPadlets.color : '255,255,255'}})`"
            >
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                >
                    <i class="ri-close-line"></i>
                </button>
                <div class="modal-body">
                    <div class="wrap-content">
                        <div class="content-wall pb-2">
                            <h5 v-if="currentPadlets.title  && currentPadlets.title != 'null'">
                                {{ currentPadlets.title }}
                            </h5>
                            <div
                                class="images pt-2"
                                v-if="currentPadlets.file_name"
                            >
                                <img
                                    :src="`${
                                        publicPath + currentPadlets.file_name
                                    }`"
                                    alt=""
                                />
                            </div>
                            <div
                                v-if="
                                    currentPadlets.content &&
                                    currentPadlets.content != 'null'
                                "
                                v-bind:innerHTML="`${currentPadlets.content}`"
                                :class="['content-messenger pt-2']"
                            ></div>
                        </div>
                        <span class="border-dark"></span>
                        <div class="d-flex justify-content-between pt-2">
                            <span class="heart">
                                <i
                                    v-if="
                                        !currentPadlets.liked ||
                                        currentPadlets.liked == 0
                                    "
                                    :class="`${'ri-heart-line'}`"
                                    @click="handleUpadtedWall"
                                    :data-id="currentPadlets.id"
                                ></i>
                                <i
                                    v-else
                                    :class="`${
                                        checkLiked(currentPadlets.data_like)
                                            ? 'ri-heart-fill'
                                            : 'ri-heart-line'
                                    }`"
                                    @click="handleUpadtedWall"
                                    :data-id="currentPadlets.id"
                                ></i>
                                <small>{{
                                    currentPadlets.liked &&
                                    currentPadlets.liked != 0
                                        ? currentPadlets.liked
                                        : ""
                                }}</small>
                            </span>
                            <span class="comment"><i class="ri-chat-3-line"></i><small>{{ currentPadlets && currentPadlets.comments.length ? currentPadlets.comments.length : '' }}</small></span>
                        </div>
                        <div class="">
                            <div class="list-messenger mt-3" v-if="currentPadlets && currentPadlets.comments.length">
                                <div class="d-flex mt-2" v-for="comment in currentPadlets.comments" :key="comment.id">
                                    <div class="avatar">
                                        <img :src="comment.avatar" alt="">
                                    </div>
                                    <div class="content-messenger">
                                        <div class="">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="name">{{ comment.fullname }}</h6>
                                                <div class="more-button">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-light btn-sm dropdown-toggle border-0 px-0 pb-0 pt-0" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ri-more-2-fill"></i>
                                                        </button>
                                                        <ul class="dropdown-menu pt-0 pb-0" v-if="dataUser.profile_id == comment.profile_id">
                                                            <li class="d-flex px-2" @click="editComment(comment.id, currentPadlets.id)"><span><i class="ri-pencil-line"></i></span><span>Chỉnh sửa bình luận</span></li>
                                                            <li class="d-flex px-2 color-red" @click="handleRemoveComment(comment.id, currentPadlets.id)"><span><i class="ri-delete-bin-line"></i></span><span>Xoá bình luận</span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <p v-if="!showEditComment[comment.id]">{{ comment.content }}</p>
                                        </div>
                                        <div class="messenger" v-if="showEditComment[comment.id]">
                                            <textarea class="autosize" v-model="comment.content"></textarea>
                                            <div class="d-flex justify-content-end mt-2 mb-2">
                                                <button class="btn btn-outline-secondary btn-sm me-2"  @click="handleCancelComment(comment.id, currentPadlets.id)">Huỷ</button>
                                                <button class="btn btn-outline-primary btn-sm" @click="handleUpdateComment(comment.id, currentPadlets.id)">Cập nhập</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mt-3">
                                <div class="avatar">
                                    <img :src="dataUser.avatar" alt="">
                                </div>
                                <div class="form-messenger">
                                    <textarea class="autosize" v-model="comment[currentPadlets.id]" placeholder="Thêm bình luận"></textarea>
                                    <span class="send" @click="handleAddComment(currentPadlets.id)"><i class="ri-arrow-right-line"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>