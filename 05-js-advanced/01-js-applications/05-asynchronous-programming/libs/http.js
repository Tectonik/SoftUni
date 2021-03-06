const http = (function ()
{
    async function postAsync(url, data)
    {
        return new Promise((resolve, reject) =>
        {
            const requestInfo = new XMLHttpRequest();

            requestInfo.addEventListener('load', function ()
            {
                resolve(this.responseText);
            });

            requestInfo.open('POST', url);
            requestInfo.setRequestHeader('content-type', 'application/json')

            requestInfo.send(data);
        });
    }

    async function getAsync(url)
    {
        return new Promise((resolve, reject) =>
        {
            const requestInfo = new XMLHttpRequest();

            requestInfo.addEventListener('load', function ()
            {
                resolve(this.responseText);
            });

            requestInfo.open('GET', url);

            requestInfo.send(null);
        });
    }

    async function updateAsync(url, data)
    {
        return new Promise((resolve, reject) =>
        {
            const requestInfo = new XMLHttpRequest();

            requestInfo.addEventListener('load', function ()
            {
                resolve(this.responseText);
            });

            requestInfo.open('PUT', url);
            requestInfo.setRequestHeader('content-type', 'application/json')

            requestInfo.send(data);
        });
    }

    async function deleteAsync(url)
    {
        return new Promise((resolve, reject) =>
        {
            const requestInfo = new XMLHttpRequest();

            requestInfo.addEventListener('load', function ()
            {
                resolve(this.responseText);
            });

            requestInfo.open('DELETE', url);

            requestInfo.send(null);
        });
    }

    return {
        postAsync,
        getAsync,
        updateAsync,
        deleteAsync
    }
}())