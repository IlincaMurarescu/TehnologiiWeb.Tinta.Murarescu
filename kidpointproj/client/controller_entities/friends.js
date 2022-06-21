fetch("http://localhost/kidpointproj/api_entities/controller/read-friends.php")
  .then((response) => {
    if (!response.ok) {
      throw Error("Error");
    }
    console.log(response);
    // console.log(response.text());
    return response.json();
  })
  .then((data) => {
    // console.log(data);
    // console.log(data[0].first_name);
    // console.log(data[1].first_name);
    // const html = data.map((child) => {
    //   return `<p>Name: ${child.first_name}`;
    // });
    let html = "";
    data.map((friend) => {
      html += `<div class="myfriends-list-element list-small-element">
      <img
        class="icon friends-icon"
        alt="House"
        src="SVG/2-persons-icon.svg"
      />
      <p class="friend-name main-info-list-element">${friend.user_name}</p>
      <p class="friend-role main-info-list-element">${friend.role}</p>
    </div>`;
    });

    // console.log(html);
    document.querySelector(".myfriends-list").innerHTML = html;

    //   document.querySelector(
    //     ".mychildren-list"
    //   ).innerHTML = `<div class="mychildren-list-element">
    //   <img class="child-icon" alt="Child" src="SVG/child-icon.svg" />
    //   <p class="child-name">${data.data.first_name} ${data.data.last_name} </p>
    //   <p class="child-details">Last seen at ${data.data.longitude}</p>
    // </div>`;
  })
  .catch((error) => {
    console.log(error);
  });
