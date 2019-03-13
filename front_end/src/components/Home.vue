<template>
	<div id="home">
		<section id="i-hero">
			<v-layout wrap align-center justify-center class="blue darken-2 white--text hero-relative py-5 fill-height">
				<v-flex xs10 sm8 md6 class="py-6">
					<h1 class="trueno-extra" :class="{'fs-60 sen-break': $vuetify.breakpoint.xsOnly, 'fs-72 text-break': $vuetify.breakpoint.smAndUp}">Hello, {{ name }}!</h1>
					<h1 class="py-3" :class="{'fs-24': $vuetify.breakpoint.xsOnly, 'fs-30': $vuetify.breakpoint.smAndUp}">Buat timelinemu sekarang!</h1>
					<v-btn color="warning" dark large @click="logout()">Logout</v-btn>
				</v-flex>
			</v-layout>
		</section>

		<v-container style="max-width: 600px;">

			<v-snackbar
				v-model="snackbar"
				:multi-line=true
				:timeout=3000
				:top=true
				:vertical=true
			>
				{{ text }}
				<v-btn
					color="white"
					flat
					@click="snackbar = false"
				>
					Close
				</v-btn>
			</v-snackbar>

			<v-card-text>
				<v-form ref="form" @submit.prevent="makeTimeline">
                    <v-layout wrap justify-center>
                       <v-flex xs11>
                          <v-text-field
                            v-model="form.title"
                            color="blue darken-2"
                            label="Title"
                            required
                          ></v-text-field>
                       </v-flex>
                       <v-flex xs11>
                          <v-text-field
                            v-model="form.content"
                            color="blue darken-2"
                            label="Content"
                            required
                          ></v-text-field>
                       </v-flex>
						<v-flex xs12 lg6>
							<v-menu
							v-model="menu"
							:close-on-content-click="false"
							full-width
							max-width="290"
							>
							<template v-slot:activator="{ on }">
								<v-text-field
								:value="computedDateFormattedMomentjs"
								clearable
								label="Formatted with Moment.js"
								readonly
								v-on="on"
								></v-text-field>
							</template>
							<v-date-picker
							color="blue"
							v-model="date"
							@change="menu = false"
							></v-date-picker>
							</v-menu>
						</v-flex>
                       <v-flex xs11 class="text-xs-center">
                          <v-btn dark flat class="blue darken-2 text-capitalize" type="submit">{{ (edit) ? 'Edit' : 'Buat' }}</v-btn>
                       </v-flex>
                    </v-layout>
                 </v-form>
			</v-card-text>

			<v-timeline>
				<v-timeline-item
					v-for="(tl, i) in timeline"
					:key="i"
					:color="tl.color"
					small
				>
				<template v-slot:opposite>
					<span
						:class="`headline font-weight-bold ${tl.color}--text`"
					>{{ tl.date | formatDate }}</span>
				</template>
				<div class="py-3">
					<h2 :class="`headline font-weight-light mb-3 ${tl.color}--text`">{{ tl.title }}</h2>
					<div>
						{{tl.content}}
					</div>
					<div>
						<v-btn dark color="orange" @click="editTimeline(tl.id)">Edit</v-btn>
						<v-btn dark color="red" @click="deleteTimeline(tl.id)">Delete</v-btn>
					</div>
				</div>
				</v-timeline-item>
			</v-timeline>
		</v-container>

	</div>
</template>

<script>
	import moment from 'moment'
	import axios from 'axios'

	export default {
		data() {
			return {
				name: localStorage.getItem('name'),
				timeline: [],
				form: {
					user_id: localStorage.getItem('id'),
					id: '',
					title: '',
					content: '',
					date: ''
				},
				snackbar: false,
				text: '',
				menu: false,
				date: new Date().toISOString().substr(0, 10),
				edit: false
			}
		},
		methods: {
			logout() {
				localStorage.clear()
				this.$router.push({name: 'user'})
			},
			makeTimeline() {
				this.form.date = this.date
				let data = this.form

				if (this.edit) {
					let url = 'https://timelineapi.derazu.tech/timeline/' + this.form.id

					if (this.form.title == null && this.form.content == null && this.form.date == null) {
						this.text = 'All field must have value!'
						this.snackbar = true
					} else {
						axios.post(url, data).then((res) => {
						if(res.data.status === 'success') {
							this.text = 'Edit Timeline Success!'
							this.snackbar = true

							this.form.id = ''
							this.form.title = ''
							this.form.content = ''
							this.form.date = ''
							this.date = ''

							this.getTimeline()
						}}).catch(() => {
							this.text = 'Edit Timeline Fail!'
							this.snackbar = true
						})
						this.snackbar = false
					}

					this.edit = false
				} else {
					let url = 'https://timelineapi.derazu.tech/timeline/'

					if (this.form.title == null && this.form.content == null && this.form.date == null) {
						this.text = 'All field must have value!'
						this.snackbar = true
					} else {
						axios.post(url, data).then((res) => {
						if(res.data.status === 'success') {
							this.text = 'Make Timeline Success!'
							this.snackbar = true

							this.form.title = ''
							this.form.content = ''
							this.form.date = ''
							this.date = ''

							this.getTimeline()
						}}).catch(() => {
							this.text = 'Make Timeline Fail!'
							this.snackbar = true
						})
						this.snackbar = false
					}
				}
			},
			getTimeline() {
				let url = 'https://timelineapi.derazu.tech/timeline/' + localStorage.getItem('id')

				axios.get(url).then((res) => {
					this.timeline = res.data.result
				}).catch(() => {
					this.text = 'Get timeline fail!'
					this.snackbar = true
				})
			},
			editTimeline(id) {
				this.edit = true
				let url = 'https://timelineapi.derazu.tech/timeline/one/' + id

				axios.get(url).then((res) => {
					this.text = 'Get timeline success, please edit now!'
					this.snackbar = true

					this.form.id = res.data.result.id
					this.form.title = res.data.result.title
					this.form.content = res.data.result.content
					this.form.date = res.data.result.date
					this.date = res.data.result.date
				}).catch(() => {
					this.text = 'Get timeline fail!'
					this.snackbar = true
				})
			},
			deleteTimeline(id) {
				let url = 'https://timelineapi.derazu.tech/timeline/' + id

				axios.delete(url).then(() => {
					this.text = 'Delete timeline success!'
					this.snackbar = true

					this.getTimeline()
				}).catch(() => {
					this.text = 'Delete timeline fail!'
					this.snackbar = true
				})
			}
		},
		computed: {
			computedDateFormattedMomentjs () {
				return this.date ? moment(this.date).format('dddd, MMMM Do YYYY') : ''
			},
		},
		filters: {
			formatDate: function (value) {
				if (value) 
					return moment(value).format('dddd, MMMM Do YYYY')
			}
		},
		created: function() {
			this.text = 'Login Success!'
			this.snackbar = true

			this.getTimeline()
		}
	}
</script>