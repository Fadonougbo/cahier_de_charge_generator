let modificationAlert = () => {
    let href = window.location.href;
    let queryString = href.search;

    let arr = href.split("?");
    let res = arr.includes("modification=1")

    if (res) {
        alert("modification reussi");
    }
};

modificationAlert()
