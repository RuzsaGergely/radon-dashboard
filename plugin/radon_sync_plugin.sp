#include <sourcemod>
#include <cstrike>
#include <ripext>
 
public Plugin myinfo =
{
	name = "Radon Dashboard sync plugin",
	author = "Ruzsa 'RuzGer' Gergely",
	description = "The plugin for synchronization with the database",
	version = "1.0",
	url = "http://ruzger.hu/"
};

/*

TO-DO:
- Get a good coffee
- Get the API running on an dev server
- Get on the job handling requests with RIP

 */

static String:filepath[PLATFORM_MAX_PATH];
static String:servernum[10];


public void OnPluginStart()
{
    HookEvent("round_start", OnRoundStart, EventHookMode_PostNoCopy); 
	CreateTimer(1.0, Check_server, _, TIMER_REPEAT);

    decl String:path[PLATFORM_MAX_PATH],String:line[10];
    BuildPath(Path_SM,path,PLATFORM_MAX_PATH,"settings.txt");
    
    new Handle:fileHandle=OpenFile(path,"r");
    while(!IsEndOfFile(fileHandle)&&ReadFileLine(fileHandle,line,sizeof(line)))
    {
        servernum = line;
    }

    CloseHandle(fileHandle);

}

public OnRoundStart(Handle:event, const String:name[], bool:dontBroadcast) 
{ 

}  

public Action Check_server(Handle timer)
{
    //PrintToChatAll(servernum);
    //ServerCommand(commandtempvar);	
}