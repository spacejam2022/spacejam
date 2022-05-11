#ifndef __PASSWD_H
#define __PASSWD_H

#include <stdio.h>

typedef struct gecos_field {
    char *irl;
    char *office;
    char *phone_office;
    char *phone_home;
    char *other;
} gecos_field_t;

typedef struct passwd_entry {
    char *login;
    char *password;
    char *uid;
    char *gid;
    char *gecos;
    char *home;
    char *shell;
} passwd_entry_t;

passwd_entry_t find_passwd_line(char *name);
passwd_entry_t parse_passwd_line(char *line);
gecos_field_t parse_gecos_field(char *field);
char **get_all_users();

#endif /* !__PASSWD_H */
