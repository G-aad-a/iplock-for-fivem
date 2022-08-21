
const fetch = require("node-fetch");
const config = require("../config.json");
const { MessageEmbed } = require("discord.js");
module.exports.run = async (client, message, args) => {
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
                .setDescription("Key Request")
                .setColor(000000)
                .setTimestamp();

            for (let i = 0; i < js.length; i++) {

                embed.addFields(
                    // { name: "ID", value: `${js[i].id}`, inline: true },
                    //{ name: "IP", value: `None`, inline: true },
                    { name : "Script ID: ", value: js[i].script_id, inline: true },
                    { name: "Your key expires on the :", value: `${js[i].expires}`, inline: false },
                    { name: "Your key:", value: `${js[i].key}`, inline: false },
                    // { name: "Expires", value: `${js[i].expires}`, inline: true }
                );
            }
  
          message.author.send(embed.setColor("BLACK").setFooter("ID:" + js.discord));
});
}