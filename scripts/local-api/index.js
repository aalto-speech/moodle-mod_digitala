const express = require('express')
const fileUpoad = require('express-fileupload')
const cors = require('cors')
const bodyParser = require('body-parser')
const morgan = require('morgan')
const { Random } = require('random-js')

const app = express()
const port = 3000

const random = new Random()

app.use(fileUpoad({
  createParentPath: true
}))
app.use(cors())
app.use(bodyParser.json())
app.use(morgan('dev'))

app.get('/', (req, res) => {
  res.status(420).send('Enhace Your Calm')
})

app.use('/resources', express.static('public'))

app.post('/', (req, res) => {
    try {
        if (req.query.key === "digitala") {
            if(!req.files) {
                res.status(418).send("418 I'm a teapot - 1")
                return
            } else {
                const audioFile = req.files.file
                const freeform = {
                    "prompt": req.query.prompt,
                    "Language": req.query.lang,
                    "Task": req.query.task,
                    "file_name": audioFile.name,
                    "Transcript": "Lorem ipsum dolor sit amet.",
                    "Fluency": {
                        "score": 3.00,
                        "mean_f1": 0.19,
                        "speech_rate": 3.12,
                    },
                    "TaskAchievement": 0.40,
                    "Accuracy": {
                        "score": 2.00,
                        "lexical_profile": 3.12,
                        "nativeity": 0.40,
                    },
                    "Holistic": 2.40,
                }
                const readaloud = {
                    "prompt": req.query.prompt,
                    "Language": req.query.lang,
                    "Task": req.query.task,
                    "file_name": audioFile.name,
                    "GOP_score": 0.7,
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