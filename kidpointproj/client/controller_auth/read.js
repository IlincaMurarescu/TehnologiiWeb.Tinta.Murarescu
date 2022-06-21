fetch("http://localhost/kidpointproj/api_auth/controller/read.php")
  .then((response) => {
    if (!response.ok) {
      throw Error("Error");
    }
    // console.log(response);
    // console.log(response.text());
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
    console.log(data);
    console.log(data.user_name);
    let html = "";
    data.map((user) => {
      html += `<li class="my-account-item">
      <label for="name">Username:</label>
      <input
        type="text"
        id="name"
        name="user_name"
        placeholder="${user.user_name}"
        disabled
        required
      />
      <a href="edit-user.html" class="btn-edit">Edit</a>
    </li>

    <li class="my-account-item">
      <label for="password">Password:</label>
      <input
        type="password"
        id="password"
        name="password"
        placeholder="Change password"
        disabled
        required
      />
      <a href="edit-password.html" class="btn-edit">Edit</a>
    </li>
    <li class="my-account-item">
      <label for="email">My e-mail:</label>
      <input
        type="text"
        id="email"
        name="email"
        placeholder="${user.user_email}"
        disabled
        required
      />
      <a href="edit-email.html" class="btn-edit">Edit</a>
    </li>`;
    });

    // console.log(html);
    document.querySelector(".my-account-list").innerHTML = html;

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
