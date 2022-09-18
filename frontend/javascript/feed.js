const tweets = document.getElementById("tweets");
const user_id = localStorage.getItem("user_id");
let shi = {
  method: "POST",
  body: new URLSearchParams({
    user_id: "" + user_id,
  }),
};
async function loadIntoPage(url) {
  const response = await fetch(url, shi);
  const data = await response.json();
  //   console.log(data);
  data.forEach(async (element) => {
    // console.log(element["id"]);

    const response2 = await fetch(
      "http://localhost/twitter-apis/grab_images.php",
      {
        method: "POST",
        body: new URLSearchParams({
          tweet_id: "" + element["id"],
        }),
      }
    );
    const data2 = await response2.json();
    console.log(data2.length);
    const tweet = document.createElement("section");
    const images = document.createElement("div");
    images.classList.add();

    const response3 = await fetch(
      "http://localhost/twitter-apis/grab_info.php",
      {
        method: "POST",
        body: new URLSearchParams({
          user_id: "" + element["users_id"],
        }),
      }
    );
    const data3 = await response3.json();
    console.log(data3);
    const profile = document.createElement("div");
    profile.classList.add("profile");
    const prof_img = document.createElement("img");
    const prof_name = document.createElement("h3");
    const prof_username = document.createElement("p");
    prof_img.src = "http://localhost/twitter-apis/" + data3[0]["profile_image"];
    profile.append(prof_img);
    prof_name.innerHTML = `${data3[0]["name"]}`;
    prof_username.innerHTML = `@${data3[0]["user_name"]}`;
    profile.append(prof_name);
    profile.append(prof_username);
    const follow = document.createElement("button");
    follow.innerHTML = "Unfollow";
    const block = document.createElement("button");
    block.innerHTML = "Block";
    profile.append(follow);
    profile.append(block);
    tweet.append(profile);

    if (data2.length > 0) {
      data2.forEach((element) => {
        const img = document.createElement("img");
        console.log(element["image_url"]);
        img.src = "http://localhost/twitter-apis/" + element["image_url"];
        images.append(img);
      });
    }
    const text = document.createElement("p");
    text.innerHTML = element["tweet_text"];
    tweet.append(text);
    tweet.append(images);
    const likes = document.createElement("section");
    const like = document.createElement("button");
    const like_num = document.createElement("p");
    like_num.id = "like";
    const likess = document.getElementById("like");

    const response4 = await fetch(
      "http://localhost/twitter-apis/like_count.php",
      {
        method: "POST",
        body: new URLSearchParams({
          tweet_id: "" + element["id"],
        }),
      }
    );
    const data4 = await response4.json();
    console.log(data4);
    like_num.innerHTML = `${data4[0]["count(user_id)"]} likes`;

    // like_num.innerHTML=`${}`;
    like.innerHTML = "Like";
    likes.append(like_num);
    likes.append(like);
    likes.classList.add("flex");
    likes.classList.add("flex-align");
    tweet.append(likes);
    tweets.append(tweet);

    follow.onclick = async () => {
      const response = await fetch(
        "http://localhost/twitter-apis/unfollow.php",
        {
          method: "POST",
          body: new URLSearchParams({
            user1: "" + user_id,
            user2: "" + element["users_id"],
          }),
        }
      );
      const data = await response.json();
      location.reload();
    };
    block.onclick = async () => {
      const response = await fetch("http://localhost/twitter-apis/block.php", {
        method: "POST",
        body: new URLSearchParams({
          user1: "" + user_id,
          user2: "" + element["users_id"],
        }),
      });
      const data = await response.json();
      location.reload();
    };
    like.onclick = async () => {
      const response = await fetch("http://localhost/twitter-apis/like.php", {
        method: "POST",
        body: new URLSearchParams({
          user_id: "" + user_id,
          tweet_id: "" + element["id"],
        }),
      });
      const data = await response.json();
      location.reload();
    };
  });
}

loadIntoPage("http://localhost/twitter-apis/show_tweets.php");

const post = document.getElementById("send");
let array = [];

document.querySelector("#files").addEventListener("change", (e) => {
  //CHANGE EVENT FOR UPLOADING PHOTOS
  if (window.File && window.FileReader && window.FileList && window.Blob) {
    //CHECK IF FILE API IS SUPPORTED
    const files = e.target.files; //FILE LIST OBJECT CONTAINING UPLOADED FILES
    const output = document.querySelector("#result");
    output.innerHTML = "";
    for (let i = 0; i < files.length; i++) {
      // LOOP THROUGH THE FILE LIST OBJECT

      if (!files[i].type.match("image")) continue; // ONLY PHOTOS (SKIP CURRENT ITERATION IF NOT A PHOTO)
      const picReader = new FileReader();
      //RETRIEVE DATA URI
      picReader.addEventListener("load", function (event) {
        // LOAD EVENT FOR DISPLAYING PHOTOS
        const picFile = event.target;
        array[i] = picFile.result.replace(/^data:image\/[a-z]+;base64,/, "");
        console.log(array);
        const div = document.createElement("div");
        div.innerHTML = `<img class="thumbnail" src="${picFile.result}" title="${picFile.name}"/>`;
        output.appendChild(div);
      });
      picReader.readAsDataURL(files[i]); //READ THE IMAGE
    }
  }
});

const message = document.getElementsByTagName("textarea").item(0);
post.onclick = async () => {
  const response = await fetch("http://localhost/twitter-apis/tweets.php", {
    method: "POST",
    body: new URLSearchParams({
      user_id: "" + user_id,
      tweet_text: message.value,
      tweet_images: array,
    }),
  })
    .then((response) => response.json())
    .then((data) => console.log(data));
};
