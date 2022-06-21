fetch(
  "http://localhost/kidpointproj/api_entities/controller/getNotification.php"
)
  .then((response) => {
    if (!response.ok) {
      throw Error("Error");
    }
    // console.log(response);
    // console.log(response.text());
    return response.json();
  })
  .then((data) => {
    console.log(data);
    // console.log(data[0].first_name);
    // console.log(data[1].first_name);
    // const html = data.map((child) => {
    //   return `<p>Name: ${child.first_name}`;
    // });
    let html = "";
    data.map((notif) => {
      html += `<div class="notification">
      <ion-icon
        class="notification-icon"
        name="alert-circle-outline"
      ></ion-icon>
      <p class="notification-text">
        ${notif.first_name} ${notif.last_name} has fallen! Please check for injuries!
      </p>
    </div>`;
    });

    // console.log(html);
    document.querySelector(".notifications-card").innerHTML = html;

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
