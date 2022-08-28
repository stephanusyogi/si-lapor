<link href="<?= base_url() ?>assets/css/chat.css" rel="stylesheet" />
    <style>
    ul{
      padding-left:0;
    }
    ol{
      padding-left:10px;
    }
    ul> li{
      list-style-type: none;
    }
  </style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid px-4">
        <!-- Chat Content-->
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card chat-app" id="containerChat">
                    <div id="plist" class="people-list">
                        <div class="text-center border-bottom p-4">
                            <h4 class="mb-0" style="color:#4b545c;">All Users List</h4>
                        </div>
                        <input class="form-control my-1" type="text" id="ccf_filter_input" onkeyup="filterSuburbs()" placeholder="search user here..." />
                        <ul class="loby-menu list-unstyled mt-2 mb-0" id="loby" style="height:100%!important;">
                        </ul>
                        <ul class="users-list list-unstyled chat-list mt-2 mb-0" id="suburbList">
                        </ul>
                    </div>
                    <div class="chat">
                        <div class="chat-header clearfix headerInfoUser py-3">
                        </div>
                        <div class="chat-history">
                            <ul class="chatApp mb-0" id="chatApp">
                            </ul>
                        </div>
                        <div class="chat-message clearfix footerChat">
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script>
    function filterSuburbs() {
        // Declare variables
        var input, filter, ul, li, about,a, title, i, txtValue;
        input = document.getElementById('ccf_filter_input');
        filter = input.value.toUpperCase();
        ul = document.getElementById("suburbList");
        li = ul.getElementsByTagName('li');

        // Loop through all list items, and hide those who don't match the search query
        for (i = 0; i < li.length; i++) {
            about = li[i].getElementsByClassName("about")[0];
            a = about.getElementsByClassName("name")[0];
            title = a.getAttribute('title');
            txtValue = title;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
            } else {
            li[i].style.display = "none";
            }
        }
    }

    const kodekesatuanFrom = "<?= str_replace('-','_',$this->session->userdata('login_data_admin')['kodekesatuan']) ?>";
    const grouplist = document.querySelector(".loby-menu");
    const usersList = document.querySelector(".users-list");
    const chatBox = document.getElementById("chatApp");

    $(document).ready(function() {
        setInterval(()=>{
            let xhrGroup = new XMLHttpRequest();
            xhrGroup.open("POST", "chat/getGroup", true);
            xhrGroup.onload = () => {
                if (xhrGroup.readyState === XMLHttpRequest.DONE) {
                    if (xhrGroup.status === 200) {
                        let data = xhrGroup.response;
                        grouplist.innerHTML = data;
                    }
                }
            }
            xhrGroup.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhrGroup.send();
        },5000)

        setInterval(()=>{
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "chat/getAllUsers", true);
            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        let data = xhr.response;
                        usersList.innerHTML = data;
                    }
                }
            }
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("kode_kesatuan=" + kodekesatuanFrom);
        },5000)
        
       
        // Add & Remove Active Class in Chatbox Div
        document.getElementById("chatApp").onmouseenter = () => {
            chatBox.classList.add("active");
        }

        document.getElementById("chatApp").onmouseleave = () => {
            chatBox.classList.remove("active");
            chatBox.scrollTop = chatBox.scrollHeight;
        }
        
    });
    
    function openMessage(kodekesatuan) {
        const kode_kesatuan = kodekesatuan;
        const headerInfoUser = document.querySelector(".headerInfoUser");
        const chatApp = document.querySelector("#chatApp");
        const idcustomer = kode_kesatuan;

        $(this).removeClass("active");
        $(this).addClass("active");

        $('.headerInfoUser').empty();
        $('.chatApp').empty();
        $('.footerChat').empty();

        $('.footerChat').append(`<form action="#" class="typing-area input-group mb-0"><input type="hidden" name="kode_kesatuan" id="kode_kesatuan" value="${kode_kesatuan}"><button id="sendBtn" class="input-group-prepend btn-secondary"><i class="fas fa-paper-plane"></i></button><input name="message" id="input-field" type="text" class="form-control" autocomplete="off" placeholder="Tulis pesan anda disini..."></form>`);

        const form = document.querySelector(".typing-area"),
            inputField = document.getElementById("input-field"),
            sendBtn = document.getElementById("sendBtn"),
            userlist = document.getElementById(`userChat${kode_kesatuan}`);

        // Preventing frorm Refresh Browser
        form.onsubmit = (e) => {
            e.preventDefault();
        }
        
        // Waktu ada inputan,button send aktif
        inputField.focus();
        inputField.onkeyup = () => {
            if (inputField.value != "") {
                sendBtn.classList.add("active");
            } else {
                sendBtn.classList.remove("active");
            }
        }
        
        // Kirim Pesan
        sendBtn.onclick = () => {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "chat/insertChat", true);
            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        inputField.value = "";
                        scrollToBottom();
                    }
                }
            }
            let formData = new FormData(form);
            xhr.send(formData);
            
            var xhrnew2 = new XMLHttpRequest();
            xhrnew2.open("POST", "chat/getmessage", true);
            xhrnew2.onload = () => {
                if (xhrnew2.readyState === XMLHttpRequest.DONE) {
                    if (xhrnew2.status === 200) {
                        let data = xhrnew2.response;
                        chatApp.innerHTML = data;
                        if (!chatBox.classList.contains("active")) {
                            scrollToBottom();
                        }
                    }
                }
            }
            xhrnew2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhrnew2.send("incoming_id=" + kode_kesatuan +"&outgoing_id=" +kodekesatuanFrom);
        }

        // Get Information User
        let xhrUser = new XMLHttpRequest();
        xhrUser.open("POST", "chat/getbyUser", true);
        xhrUser.onload = () => {
            if (xhrUser.readyState === XMLHttpRequest.DONE) {
                if (xhrUser.status === 200) {
                    let data = xhrUser.response;
                    headerInfoUser.innerHTML = data;
                }
            }
        }
        xhrUser.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhrUser.send("kode_kesatuan=" + kode_kesatuan);

        // Get Message
        let xhrMessage = new XMLHttpRequest();
        xhrMessage.open("POST", "chat/getmessage", true);
        xhrMessage.onload = () => {
            if (xhrMessage.readyState === XMLHttpRequest.DONE) {
                if (xhrMessage.status === 200) {
                    let data = xhrMessage.response;
                    chatBox.innerHTML = data;
                    if (!chatBox.classList.contains("active")) {
                        chatBox.scrollTop = chatBox.scrollHeight;
                    }
                }
            }
        }
        xhrMessage.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhrMessage.send("incoming_id=" + kode_kesatuan +"&outgoing_id=" +kodekesatuanFrom);
        
        function scrollToBottom() {
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    };

    function updateIsRead(kodekesatuan){
        // Update isRead
        var xhrIsRead = new XMLHttpRequest();
        xhrIsRead.open("POST", "chat/updateIsRead", true);
        xhrIsRead.onload = () => {
            if (xhrIsRead.readyState === XMLHttpRequest.DONE) {
                if (xhrIsRead.status === 200) {
                    let data = xhrIsRead.response;
                }
            }
        }
        xhrIsRead.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhrIsRead.send("incoming_id=" + kodekesatuan);

        
        $(function() {
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            showCloseButton: true,
            timer: 5000
          });

          Toast.fire({
            icon: 'success',
            title: `&nbsp;Pesan dari ${kodekesatuan} sudah dibaca.`
          })
        });
    };

    function openMessageGroup() {
        const kode_kesatuan = "<?= $this->session->userdata('login_data_admin')['kodekesatuan'] ?>";
        const headerInfoUser = document.querySelector(".headerInfoUser");
        const chatApp = document.querySelector("#chatApp");
        const srcImage = "<?= base_url() ?>assets/images/group.png";

        $(this).removeClass("active");
        $(this).addClass("active");

        $('.headerInfoUser').empty();
        $('.chatApp').empty();
        $('.footerChat').empty();

        $('.footerChat').append(`<form action="#" class="typing-area input-group mb-0"><input type="hidden" name="kode_kesatuan" id="kode_kesatuan" value="${kode_kesatuan}"><button id="sendBtn" class="input-group-prepend btn-secondary"><i class="fas fa-paper-plane"></i></button><input name="message" id="input-field" type="text" class="form-control" autocomplete="off" placeholder="Tulis pesan anda disini..."></form>`);

        const form = document.querySelector(".typing-area"),
            inputField = document.getElementById("input-field"),
            sendBtn = document.getElementById("sendBtn"),
            userlist = document.getElementById(`userChat${kode_kesatuan}`);

        // Preventing frorm Refresh Browser
        form.onsubmit = (e) => {
            e.preventDefault();
        }
        
        // Waktu ada inputan,button send aktif
        inputField.focus();
        inputField.onkeyup = () => {
            if (inputField.value != "") {
                sendBtn.classList.add("active");
            } else {
                sendBtn.classList.remove("active");
            }
        }
        
        // Kirim Pesan
        sendBtn.onclick = () => {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "chat/insertChatGroup", true);
            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        inputField.value = "";
                        scrollToBottom();
                    }
                }
            }
            let formData = new FormData(form);
            xhr.send(formData);
            
            var xhrnew2 = new XMLHttpRequest();
            xhrnew2.open("POST", "chat/getmessagegroup", true);
            xhrnew2.onload = () => {
                if (xhrnew2.readyState === XMLHttpRequest.DONE) {
                    if (xhrnew2.status === 200) {
                        let data = xhrnew2.response;
                        chatApp.innerHTML = data;
                        if (!chatBox.classList.contains("active")) {
                            chatBox.scrollTop = chatBox.scrollHeight;
                        }
                    }
                }
            }
            xhrnew2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhrnew2.send();
        }

        // Get Information User
        headerInfoUser.innerHTML = `<div class='row'><div class='col-lg-10'><img class='mt-1' src='${srcImage}' alt='avatar'><div class='chat-about'><h3 class='my-2'>LOBI GROUP COMMUNICATION</h3></div></div></div>`;

        // Get Message
        let xhrMessage = new XMLHttpRequest();
        xhrMessage.open("POST", "chat/getmessagegroup", true);
        xhrMessage.onload = () => {
            if (xhrMessage.readyState === XMLHttpRequest.DONE) {
                if (xhrMessage.status === 200) {
                    let data = xhrMessage.response;
                    chatBox.innerHTML = data;
                    if (!chatBox.classList.contains("active")) {
                        chatBox.scrollTop = chatBox.scrollHeight;
                    }
                }
            }
        }
        xhrMessage.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhrMessage.send();
        
        function scrollToBottom() {
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    };

    function delChat(iduserchat) {
        Swal.fire({
            title: "Hapus Pesan ?",
            text: "Aksi ini tidak dapat dikembalikan",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Delete!",
        }).then((result) => {
            if (result.isConfirmed) {
                var xhrdel = new XMLHttpRequest();
                xhrdel.open("POST", "chat/deleteChat", true);
                xhrdel.onload = () => {
                    if (xhrdel.readyState === XMLHttpRequest.DONE) {
                        if (xhrdel.status === 200) {
                            let data = xhrdel.response;

                            var xhrDelete = new XMLHttpRequest();
                            xhrDelete.open("POST", "chat/getmessagegroup", true);
                            xhrDelete.onload = () => {
                                if (xhrDelete.readyState === XMLHttpRequest.DONE) {
                                    if (xhrDelete.status === 200) {
                                        let data = xhrDelete.response;
                                        document.querySelector("#chatApp").innerHTML = data;
                                        if (!chatBox.classList.contains("active")) {
                                            chatBox.scrollTop = chatBox.scrollHeight;
                                        }
                                    }
                                }
                            }
                            xhrDelete.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                            xhrDelete.send();
                        }
                    }
                }
                xhrdel.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhrdel.send("incoming_id=" + iduserchat);
                
            }
        });
    };


  </script>