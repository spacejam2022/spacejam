#ifndef __UTIL_H
#define __UTIL_H

char **split(char *s, char delim);
char *trim(char *s);
char *get_last_login(const char *name);
char *get_user_plan(const char *user);
char *get_text_contents(const char *path);

#endif /* !__UTIL_H */
