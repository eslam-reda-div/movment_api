
<div>

    <h1>Test Broadcast</h1>
    <div id="content"></div>

    @vite(['resources/js/app.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            window.Echo.channel('bus-location')
                .listen('.client-send', (e) => {
                    //desplay the data
                    console.log(e);
                    //make it list the data in the #content dev as key and value each one in a senglie line
                    let content = document.getElementById('content');
                    content.innerHTML = '';
                    for (let key in e) {
                        let p = document.createElement('p');
                        p.innerText = key + ': ' + e[key];
                        content.appendChild(p);
                    }
                });
        });
    </script>
</div>
