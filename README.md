# Usage
* Create a [https://core.telegram.org/bots#3-how-do-i-create-a-bot](Telegrambot)
* Add the bot to a group chat and write down the group chat it

The bot will request data from the datasource and send a message via the TelegramBot Class to the given chat it.

# Customization
If the data are given in other formats create and implement a new dataprovider.

# Datasource
The datasource is provided by the [https://vorarlberg.at/coronadashboard](official dashboard of Vorarlberg). To find the urls open the developer toolbar and search in the requests for "services-eu1".
The url goes into the .env-param `CORONA_DATA_URL`
