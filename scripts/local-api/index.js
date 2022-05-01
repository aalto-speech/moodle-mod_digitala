const express = require('express')
const fileUpload = require('express-fileupload')
const cors = require('cors')
const bodyParser = require('body-parser')
const morgan = require('morgan')
const { Random } = require('random-js')

const app = express()
const port = 3000

const random = new Random()

app.use(fileUpload({
  createParentPath: true
}))
app.use(cors())
app.use(bodyParser.json())
app.use(morgan('dev'))

/**
 * @swagger
 * /:
 *   get:
 *     summary: Placeholder response for unused GET-method. Used for health check.
 *     responses:
 *       420:
 *         description: Returned if everything is okay
 */
app.get('/', (req, res) => {
  res.status(420).send('Enhace Your Calm')
})

/**
 * @swagger
 * /resources:
 *   get:
 *     summary: Static files served for tests
 *     responses:
 *       200:
 *         description: Returns asked file.
 */
app.use('/resources', express.static('public'))

/**
 * @swagger
 * /:
 *   post:
 *     summary: Returns dummy evaluation in same format as Aalto ASR -api would.
 *     responses:
 *       200:
 *         description: Returns evaluation.
 *       418:
 *         description: If something goes wrong. For example if key, file or fields is missing.
 */
app.post('/', (req, res) => {
    try {
        if (req.query.key === "digitala") {
            if(!req.files) {
                res.status(418).send("418 I'm a teapot - 1")
                return
            } else {
                const audioFile = req.files.file
                const freeform = {
                    "file_name": audioFile.name,
                    "Language": req.query.lang,
                    "Task": req.query.task,
                    "prompt": req.query.prompt,
                    "transcript": "Lorem ipsum dolor sit amet.",
                    "task_completion": 0.39,
                    "holistic": 2,
                    "fluency": {
                        "score": 1,
                        "flu_features": {
                            "invalid": 1
                        }
                    },
                    "pronunciation": {
                        "score": 3,
                        "pron_features": {
                            "invalid": 2
                        }
                    },
                    "lexicogrammatical": {
                        "score": 2,
                        "lexgram_features": {
                            "invalid": 3
                        }
                    },
                }
                const readaloud = {
                    "file_name": audioFile.name,
                    "Language": req.query.lang,
                    "Task": req.query.task,
                    "prompt": req.query.prompt,
                    "transcript": "Lorem ipsum dolor sit amet.",
                    "annotated_response": "<p><span class=\"digitala-transcript-success\">Lorem </span><span class=\"digitala-transcript-error\">ipsum </span><span class=\"digitala-transcript-warning\">dol</span>or <span class=\"digitala-transcript-success\">sit </span><span class=\"digitala-transcript-error\">a</span><span class=\"digitala-transcript-warning\">met.</span></p>",
                    "fluency": {
                        "score": 1,
                        "flu_features": {
                            "invalid": 1
                        }
                    },
                    "pronunciation": {
                        "score": 3,
                        "pron_features": {
                            "invalid": 2
                        }
                    },
                }

                const answer = req.query.task === "freeform" ? freeform : readaloud

                const waitTime = req.query.wait ? random.integer(0,10)*1000 : 0

                setTimeout(() => {
                    res.json(answer)
                }, waitTime)
            }
        } else {
            res.status(418).send("418 I'm a teapot - 2")
        }
    } catch (err) {
        res.status(418).send("418 I'm a teapot - 3")
    }
})

app.listen(port, () => {
  console.log(`Example app listening on port ${port}`)
})