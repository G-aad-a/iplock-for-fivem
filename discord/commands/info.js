
const fetch = require("node-fetch");
const config = require("../config.json");
const { MessageEmbed } = require("discord.js");
var { isAllowed } = require("../Functions.js");
module.exports.run = async (client, message, args) => {


    if(!isAllowed(message)) {
        return message.reply(":/")
    }


    let target = message.mentions.users.first() 

    if(!target) {
        target = message.author
    }


    await fetch(
        `http://${config.host}/action.php?action=getUserInfo&discord=${message.author.id}`
    )
        .then((res) => res.json())
        .then((json) => {
            //console.log(json);
            if(json["code"] !== undefined) {
                console.log("you dont own a license!")
                return
            }

            var js = json["content"]

            console.log(js)
            var embed = new MessageEmbed()
                .setDescription("Expiry Request")
                .setColor(000000)
                .setTimestamp();

            for (let i = 0; i < js.length; i++) {

                embed.addFields(
                    // { name: "ID", value: `${js[i].id}`, inline: true },
                    //{ name: "IP", value: `None`, inline: true },
                    { name : "Script ID: ", value: js[i].script_id, inline: true },
                    { name: "key expires on the :", value: `${js[i].expires}` , inline: true },
                    { name: "ServerName: ", value: js[i].servername, inline: true},
                    { name: "Banned: ", value: js[i].disabled, inline: true},
                    { name: "ip: ", value: js[i].ip, inline: true},
                    { name: "key: ", value: js[i].key, inline: true},
                    { name: '\u200B', value: '\u200B' },
                    // { name: "Expires", value: `${js[i].expires}`, inline: true }
                );
            }
  
          message.channel.send(embed.setColor("BLACK").setFooter("ID:" + js[0].discord));
});
}