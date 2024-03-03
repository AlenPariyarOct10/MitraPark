async function fetchPosts() {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: "./server/api/get-posts.php",
        type: "POST",
        success: (data) => {
          console.log(JSON.parse(data));
          resolve(JSON.parse(data));
        },
        error: (error) => {
          reject(error);
        }
      });
    });
  }

    function likeHandeler() {
    console.log("hello");
    let postLikes = document.querySelectorAll(".like-container");
    console.log(postLikes);
    postLikes.forEach((item) => {
        item.addEventListener("click", () => {
            console.log(item.dataset.id);
            console.log(item.childNodes[1].src);
            let id = item.dataset.id;
            item.childNodes[1].src = '/MitraPark/assets/images/heart-solid.svg';

            $.ajax({
                url: "./server/api/addLike.php",
                type: "POST",
                data: {postId: id},
                success: (msg)=>{
                    console.log(msg);
                },
                error: (msg)=>{
                    console.log(msg);
                }
              });
        })
        console.log(item);
    })
}
  
  async function renderPosts() {
    try {
      const postData = await fetchPosts();
      const postPlace = document.querySelector(".mid-body");
      
      postData.forEach(postItem => {
        const postHTML = `
          <div class="post-item">
            <div class="post-item-head">
              <div class="post-item-head-left">
                <img class="profile-picture-holder" src="/MitraPark/alen-profile.jpg" alt="" srcset="">
              </div>
              <div class="post-item-head-right">
                <div class="post-user">
                  <span>${postItem.fname + " " + postItem.lname}</span>
                </div>
                <div class="post-details">
                  <span>${postItem.visibility}</span>
                  <span>|</span>
                  <span>${postItem.created_date_time} </span>
                </div>
              </div>
            </div>
            <div class="post-item-body">
              <span>${postItem.content}</span>
              <img src=".${postItem.media}" alt="" srcset="">
            </div>
            <div class="post-item-footer">
              <div data-id=${postItem.post_id} class="like-container">
                <img height="20px" src=${(postItem.liked!=null)?"./assets/images/heart-solid.svg":"./assets/images/heart-outline.svg"}>
                <span></span>
              </div>
              <div class="comment-container">
                <img height="20px" src="./assets/images/comment-outline.svg">
                <span></span>
              </div>
            </div>
          </div>
        `;
        postPlace.innerHTML += postHTML;
      });
    } catch (error) {
      console.error("Error fetching or rendering posts:", error);
    }
  }
  
  // Call the renderPosts function to fetch and render posts asynchronously
  renderPosts().then(() => {
    likeHandeler();
}).catch(error => {
    console.error("Error rendering posts:", error);
});

  