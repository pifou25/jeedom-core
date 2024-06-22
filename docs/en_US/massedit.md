# Mass editor

**Settings → System → Configuration | OS / DB**

This tool allows you to edit a large number of equipment, commands, objects, or scenarios. It is completely generic, and automatically uses the schema and structure of the Jeedom database. It thus supports plugins and the configuration of their equipment.

> **Attention**
>
> If this tool is quite easy to use, it is intended for advanced users. Indeed, it is in fact very simple to change any parameter on dozens of devices or hundreds of commands and therefore to make certain functions inoperative, see even the Core.

## Utilisation

The part _Filtered_ allows you to select what you want to edit, then add selection filters according to their parameters. A test button allows, without any modification, to show you the items selected by the filters entered.

The part _Editing_ allows you to change parameters on these items.

- **Column** : Setting.
- **Value** : The value of the parameter.
- **Json value** : The property of the parameter / value if it is of type json (key-> value).

### Exemples:

#### Rename a scenario group

- In the game _Filtered_, select **Scenario**.
- Click on the button **+** to add a filter.
- In this filter, select the column _group_, and highlight the name of the group to rename.
- Click on the button _Test_ to display the scenarios of this group.
- In the game _Editing_, select column _group_, then put the name you want in the value.
- Click on **Execute** top right.

#### Make all the equipment of an object / room invisible:

- In the game _Filtered_, select **Equipment**.
- Click on the button **+** to add a filter.
- In this filter, select the column _object_id_, and in value the id of the object in question (visible from Tools / Objects, Overview).
- Click on the button _Test_ to display the scenarios of this group.
- In the game _Editing_, select column _isvisible_, then enter the value 0.
- Click on **Execute** top right.
