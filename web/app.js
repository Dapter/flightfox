var app;

(function () {
    var xhttpPromise = function (type, url, data) {
        return new Promise(function (resolve, reject) {
            var xhttp = new XMLHttpRequest();
            xhttp.onload = function () {
                if (xhttp.status === 200) {
                    resolve(JSON.parse(xhttp.response));
                } else {
                    xhttp(Error(xhttp.statusText));
                }
            };

            xhttp.onerror = function () {
                reject(Error("Network Error"));
            };

            xhttp.open(type, url, true);
            xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
            xhttp.send(data);
        });
    };

    var xhttp = {
        get: function (url, success, error) {
            return xhttpPromise('GET', url).then(success, error);
        },
        post: function (url, data, success, error) {
            return xhttpPromise('POST', url, data).then(success, error);
        }
    }

    var render = function (data) {
        var html = '';
        var optionsHtml = '';
        var template = document.getElementById('list-item-template');
        var select = document.querySelector('select');

        var getOptionElement = function (priority) {
            var option = document.createElement('option');
            option.setAttribute('value', priority);
            option.innerHTML = priority;

            return option;
        };

        select.innerHTML = '';

        for (var i = 0; i < data.length; i++) {
            var liContent = '<li data-priority=' + data[i].priority + '>' + data[i].item + ' | ';
            liContent += (data[i].is_completed == '0' ? '<a href="#" onclick="complete(event)">Complete</a>' : 'Done!') + '</li>';
            html += liContent;
            document.querySelector('select').appendChild(getOptionElement(i + 1));
        }

        select.appendChild(getOptionElement(i + 1));
        document.querySelector('ul').innerHTML = html;
    };

    app = {
        router: {
            index: function () {
                xhttp.get('index', function (response) {
                    render(response);
                    return true;
                }, alert);
            },
            add: function (data) {
                xhttp.post('add', data, function (response) {
                    if (response) {
                        app.router.index();
                    }
                }, alert);
            },
            complete: function (priority) {
                xhttp.get('setCompleted/' + priority, function (response) {
                    if (response) {
                        app.router.index();
                    }
                }, alert)
            }
        }
    };
}());

app.router.index();

function addItem(event) {
    event.preventDefault();
    app.router.add(new FormData(event.currentTarget))

    return false;
}

function complete(event) {
    app.router.complete(event.currentTarget.parentElement.dataset.priority);
}