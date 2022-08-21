var config = require("./config.json")
var dis = require("discord.js")

var fetch = require("node-fetch")


function isAllowed(mes) {
    let allowed = false

    config.allowed.forEach(e => {
        if (mes.member.roles.cache.some(role => role.id === e)) {
            allowed = true
        }
    });

    if (allowed != true) {
        return false;
    } else {
        return true;
    }

}


function isGenAllowed(mes) {
    let allowed = false

    config.allowedGen.forEach(e => {
        if (mes.member.roles.cache.some(role => role.id === e)) {
            allowed = true
        }
    });

    if (allowed != true) {
        return false;
    } else {
        return true;
    }

}


function sendWebhook(messagee, alert) {
    if (alert === 1) {
        fetch(config.blacklist_web, {
            "method": "POST",
            "headers": { "Content-Type": "application/json" },
            "body": JSON.stringify({
                "content": messagee
            })

        })
    } else if (alert === 2) {
        fetch(config.claim_web, {
            "method": "POST",
            "headers": { "Content-Type": "application/json" },
            "body": JSON.stringify({
                "content": messagee
            })

        })
    } else if (alert === 2) {
        fetch(config.setip_web, {
            "method": "POST",
            "headers": { "Content-Type": "application/json" },
            "body": JSON.stringify({
                "content": messagee
            })

        })
    }
}

module.exports = {
    isAllowed,
    isGenAllowed,
    sendWebhook
}