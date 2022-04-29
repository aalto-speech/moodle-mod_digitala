# local-api

In folder `scripts/local-api` is located files for running local representation of Aalto ASR -server. Local-API is returning dummy data in valid format. All tests and CI-pipeline is running tests against this. This will also serve static files used in tests.

## How to run?

1. Go to `scripts/local-api` folder.
2. Check that network name in `docker-compose.dev.yml` matches your Moodle development environment. This defaults to Moodle's own Docker environment name `moodle-docker_default`. If running Moodle locally without Docker, just change network's setting `external` to `false`. Do **NOT** touch `docker-compose.yml`-file or otherwise CI-pipeline will broke.
3. Run command `docker-compose -f docker-compose.dev.yml up -d`. This will start the Local-API container.
4. Now container should accessible. Locally it will answer from `http://localhost:3000` and in container network `http://digitala-api:3000`. Plugin will default to this one. Key for this is `digitala`.
5. If shutting environment down, run command `docker-compose -f docker-compose.dev.yml down`.

## Notes

- You can check if API is running by doing GET-request to endpoint `/`. It should return HTTP 420 with message `Enhace Your Calm` if everything is alright.
- Static resources is served in endpoint `/resources`. All files attached to folder `scripts/local-api/static` is served at this endpoint with files name.
- If something goes wrong, for example file is not attached, key is wrong or fields is missing, server will return HTTP 418 with message `418 I'm a teapot.` and number of occuring raising point in API.
- If adding url parameter `wait` with any value, it will give random waittime between 0 and 10 seconds before sending answer.
