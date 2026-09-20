{{- define "tundra.name" -}}
{{- .Chart.Name -}}
{{- end -}}

{{- define "tundra.fullname" -}}
{{- .Release.Name -}}-{{- .Chart.Name -}}
{{- end -}}

{{- define "tundra.labels" -}}
app.kubernetes.io/name: {{ include "tundra.name" . }}
app.kubernetes.io/instance: {{ .Release.Name }}
app.kubernetes.io/managed-by: {{ .Release.Service }}
helm.sh/chart: {{ .Chart.Name }}-{{ .Chart.Version }}
{{- end -}}

{{- define "tundra.selectorLabels" -}}
app.kubernetes.io/name: {{ include "tundra.name" . }}
app.kubernetes.io/instance: {{ .Release.Name }}
{{- end -}}

{{/*
Shared env vars for both the app Deployment and the migration Job --
kept in one place so the two never drift apart. Non-secret values come
from the ConfigMap (templates/configmap.yaml), secrets from the Secret
(templates/secret.yaml). Dotted names (CI4's .env-style config keys,
see app/Config/App.php etc.) are valid Kubernetes env var names --
confirmed against a real API server, not just assumed.
*/}}
{{- define "tundra.configEnvKeys" -}}
CI_ENVIRONMENT
app.baseURL
database.default.hostname
database.default.database
database.default.port
database.default.encrypt.ssl_verify
database.default.encrypt.ssl_ca
session.driver
session.cookieName
session.savePath
cache.handler
cache.redis.host
cache.redis.port
{{- end -}}

{{- define "tundra.env" -}}
{{- $fullname := include "tundra.fullname" . -}}
{{- range (include "tundra.configEnvKeys" . | trim | splitList "\n") }}
- name: {{ . }}
  valueFrom:
    configMapKeyRef:
      name: {{ $fullname }}
      key: {{ . }}
{{- end }}
- name: database.default.username
  valueFrom:
    secretKeyRef:
      name: {{ $fullname }}
      key: database-username
- name: database.default.password
  valueFrom:
    secretKeyRef:
      name: {{ $fullname }}
      key: database-password
- name: cache.redis.password
  valueFrom:
    secretKeyRef:
      name: {{ $fullname }}
      key: redis-password
- name: encryption.key
  valueFrom:
    secretKeyRef:
      name: {{ $fullname }}
      key: encryption-key
{{- end -}}
