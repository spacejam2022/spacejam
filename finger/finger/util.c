#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <ctype.h>
#include <unistd.h>

#include "util.h"

static char *parts[10];

char **split(char *s, char delim) {
    bzero(parts, sizeof(parts));
    parts[0] = s;
    int n = 1;
    for (int i = 0; s[i]; ++i) {
        if (s[i] == delim) {
            parts[n++] = s + i + 1;
            s[i] = '\0';
        }
    }
    return parts;
}

char *trim(char *s) {
    int n = strlen(s) - 1;
    while (n >= 0 && isspace(s[n])) {
        s[n--] = '\0';
    }
    return s;
}

void cleanup(char *s, char e) {
    int i;
    int len=strlen(s);
    for (i=0;i<len;i++) {
	if (s[i] == e) {
            s[i] = '\0';
        }
    }
}

static char last[4096];

char *get_last_login(const char *name) {
    char *tmp = tempnam("/tmp", "last");
    char cmd[1024];
    sprintf(cmd, "last %s | head -1 > %s", name, tmp);
    cleanup(cmd, ';');
    system(cmd);
    strncpy(last, get_text_contents(tmp), sizeof(last));
    unlink(tmp);
    return trim(last);
}

static char plan[4096];

char *get_user_plan(const char *user) {
    char path[128];
    sprintf(path, "/home/%s/.plan", user);
    return strncpy(plan, get_text_contents(path), sizeof(plan));
}

static char contents[1000];

char *get_text_contents(const char *path) {
    FILE *f = fopen(path, "rt");
    if (f) {
        int n = fread(contents, 1, sizeof(contents) - 1, f);
        contents[n] = 0;
        fclose(f);
    } else {
        return "N/A";
    }
    return trim(contents);
}
