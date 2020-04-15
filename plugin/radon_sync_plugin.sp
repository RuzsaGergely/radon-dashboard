#include <sourcemod>
#include <cstrike>
#include <ripext>
 
public Plugin myinfo =
{
	name = "Radon Dashboard Sync",
	author = "Ruzsa 'RuzGer' Gergely",
	description = "The plugin for synchronization with the database",
	version = "1.0",
	url = "http://ruzger.hu/"
};

/*

TO-DO:
- Moving to the point system

 */

char servernum[10];
char gettask[512];

HTTPClient httpClient;

public void OnPluginStart()
{
    HookEvent("round_start", OnRoundStart, EventHookMode_PostNoCopy); 
	CreateTimer(0.5, Check_server, _, TIMER_REPEAT);

    decl String:path[PLATFORM_MAX_PATH];
    BuildPath(Path_SM,path,PLATFORM_MAX_PATH,"settings.txt");
    
    new Handle:fileHandle=OpenFile(path,"r");

    /*while(!IsEndOfFile(fileHandle)&&ReadFileLine(fileHandle,line,sizeof(line)))
    {
        servernum = line;
    }*/

    ReadFileLine(fileHandle,servernum,sizeof(servernum));

    ReadFileLine(fileHandle,gettask,sizeof(gettask));

    char site[1024];
    ReadFileLine(fileHandle,site,sizeof(site));

    CloseHandle(fileHandle);

    httpClient = new HTTPClient(site);
}

public OnRoundStart(Handle:event, const String:name[], bool:dontBroadcast) 
{ 

}  


// This function checks the server for jobs
public Action Check_server(Handle timer)
{

    char url_sufix[512];
    Format(url_sufix, sizeof(url_sufix), "/getTasks/%d", StringToInt(servernum));
    //PrintToChatAll(site);
    //PrintToChatAll(urlextend);
    
    httpClient.Get(url_sufix, OnJobReceived);

}

public void OnJobReceived(HTTPResponse response, any value)
{
    if (response.Status != HTTPStatus_OK) {
        PrintToChatAll("No repsonse!!");
        return;
    }
    if (response.Data == null) {
        PrintToChatAll("Invalid json!!");
        return;
    }

    // Indicate that the response is a JSON array
    JSONArray jobs = view_as<JSONArray>(response.Data);
    int jobLength = jobs.Length;

    JSONObject job;

    for (int i = 0; i < jobLength; i++) {

        job = view_as<JSONObject>(jobs.Get(i));

        char jobNum[256];
        char jobTask[256];
        job.GetString("tasknum", jobNum, sizeof(jobNum));
        job.GetString("task", jobTask, sizeof(jobTask))

        PrintToServer("Retrieved job with task of '%s'", jobTask);
        PrintToChatAll(jobTask);
        ServerCommand(jobTask);

        char url_sufix[512];
        Format(url_sufix, sizeof(url_sufix), "/doneTask/%d", StringToInt(servernum));
        JSONObject postObject = new JSONObject();
        postObject.SetInt("tasknum", StringToInt(jobNum));
        httpClient.Post(url_sufix, postObject, OnTaskDone);

        delete postObject;
        delete job;
    }

    delete jobs;
} 

public void OnTaskDone(HTTPResponse response, any value)
{
    if (response.Status != HTTPStatus_Created) {
        // Failed to create todo
        return;
    }
    if (response.Data == null) {
        // Invalid JSON response
        return;
    }

    JSONObject todo = view_as<JSONObject>(response.Data);
    int todoId = todo.GetInt("id");

    PrintToServer("Created todo with ID %d", todoId);
} 