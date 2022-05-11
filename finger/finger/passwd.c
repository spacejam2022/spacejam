#include <string.h>
#include <stdlib.h>

#include "passwd.h"
#include "util.h"

static char line[200];
static passwd_entry_t entry;

passwd_entry_t find_passwd_line(char *name) {
    FILE *f = fopen("/etc/passwd", "rt");
    if (f) {
        while (fgets(line, sizeof(line), f)) {
            entry = parse_passwd_line(trim(line));
            if (!strncmp(entry.login, name, strlen(entry.login))) {
                fclose(f);
                return entry;
            }
        }
    }
    fclose(f);
    entry.login = NULL;
    return entry;
}

passwd_entry_t parse_passwd_line(char *line) {
    passwd_entry_t result;
    char **parts = split(line, ':');
    result.login = parts[0];
    result.password = parts[1];
    result.uid = parts[2];
    result.gid = parts[3];
    result.home = parts[5];
    result.shell = parts[6];
    result.gecos = parts[4];
    return result;
}

gecos_field_t parse_gecos_field(char *field) {
    gecos_field_t result;
    char **parts = split(field, ',');
    result.irl = parts[0] ? parts[0] : "";
    result.office = parts[1] ? parts[1] : "";
    result.phone_office = parts[2] ? parts[2] : "";
    result.phone_home = parts[3] ? parts[3] : "";
    result.other = parts[4] ? parts[4] : "";
    return result;
}

char *users[100];

char **get_all_users() {
    FILE *f = fopen("/etc/passwd", "rt");
    int n = 0;
    if (f) {
        while (fgets(line, sizeof(line), f)) {
            entry = parse_passwd_line(trim(line));
            if (atoi(entry.uid) >= 1000) {
                users[n++] = strdup(entry.login);
            }
        }
    }
    users[n] = NULL;
    fclose(f);
    return users;
}
