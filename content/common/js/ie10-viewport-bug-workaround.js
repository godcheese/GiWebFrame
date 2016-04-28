/**
 * Created by Administrator on 2015/10/29.
 */

//Windows 8 中的 Internet Explorer 10 和 Windows Phone 8 js代码段
if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
    var msViewportStyle = document.createElement("style")
    msViewportStyle.appendChild(
        document.createTextNode(
            "@-ms-viewport{width:auto!important}"
        )
    )
    document.querySelector("head").appendChild(msViewportStyle)
}