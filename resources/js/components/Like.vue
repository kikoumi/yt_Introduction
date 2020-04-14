<template>
   
        <i v-if="!liked" class="far fa-heart  LikesIcon-fa-heart float-right mr-5" style="color:#333; font-size:30px; cursor : pointer;" @click="like(postId)">{{ likeCount }}</i>
        <i v-else class="fas fa-heart  LikesIcon-fa-heart float-right mr-5" style="color:#e2264d;font-size:30px; cursor : pointer;" @click="unlike(postId)">{{ likeCount }}</i>
   
</template>

<script>
    export default {
        props: ['postId','userId','defaultLiked','defaultCount'],
        data(){
            return {
                liked:false,
                likeCount: 0,
            }
        },
        created () {
            this.liked = this.defaultLiked
            this.likeCount = this.defaultCount
        },
        
        methods: {
            like(postId) {
                let url = `/api/posts/${postId}/like`
                axios.post(url,{
                    user_id: this.userId
                })
                .then(response => {
                    this.liked = true
                    this.likeCount = response.data.likeCount
                })
                .catch(error => {
                  alert(error)
                });
            },
            unlike(postId) {
                let url = `/api/posts/${postId}/unlike`
                axios.post(url,{
                    user_id: this.userId
                })
                .then(response => {
                    this.liked = false
                    this.likeCount = response.data.likeCount
                })
                .catch(error => {
                  alert(error)
                });
            }
        }
    }
</script>