# == Roots of the synchronization ==
root = ${WORKSPACE_ROOT}
root = ${REPLICA_URI}

# == Flags and configurations ==
#   continuous synchronization
repeat = watch
#   automatically accepts no-conflicting-changes
auto = true
#   not-interactive mode
batch = true
#   enable fastcheck (default is true, but ¯\_(ツ)_/¯)
fastcheck = true
#   do not generate backup on conflicts
backups = false
#   remove status logging
terse = true
#   do not log on disk
log = false

# == Common ignores ==
ignore = Path .git
ignore = Path .idea
# Ignore docker-related files for production build and development
ignore = Path .docker
ignore = Path .docker-dev
ignore = Name .DS_Store
# This is used to ignore jetbrain temporary files created by phpstorm with complex actions
ignore = Name *___jb_tmp___*
ignore = Name *___jb_old___*
# This is used to ignore caches
ignore = Path var/{cache,log}

# Prefer vendor folders from remote to ${WORKSPACE_ROOT} (on conflicts)
preferpartial = Path ./{vendor,node_modules} -> ${REPLICA_URI}

# Prefer source from host
preferpartial = Path ./src -> ${WORKSPACE_ROOT}
